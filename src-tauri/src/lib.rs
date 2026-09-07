use std::sync::Mutex;

struct PhpProcess(Mutex<Option<std::process::Child>>);
#[cfg_attr(mobile, tauri::mobile_entry_point)]
pub fn run() {
    tauri::Builder::default()
        .setup(|app| {
            if cfg!(debug_assertions) {
                app.handle().plugin(
                    tauri_plugin_log::Builder::default()
                        .level(log::LevelFilter::Info)
                        .build(),
                )?;
            }

            #[cfg(not(debug_assertions))]
            {
                use std::os::windows::process::CommandExt;
                use tauri::Manager;

                let resource_dir = app
                    .path()
                    .resource_dir()
                    .expect("Resource directory tidak ditemukan");

                // Folder data user di Windows AppData
                let app_data_dir = app
                    .path()
                    .app_data_dir()
                    .expect("AppData directory tidak ditemukan");

                std::fs::create_dir_all(&app_data_dir)
                    .expect("Gagal membuat folder AppData");

                // Database aktif milik user
                let user_database = app_data_dir.join("database.sqlite");

                // Database template dari installer
                let template_database = resource_dir
                    .join("resources")
                    .join("database-template")
                    .join("database.sqlite");

                // Hanya copy pada pertama kali aplikasi dijalankan
                if !user_database.exists() {
                    std::fs::copy(&template_database, &user_database)
                        .expect("Gagal membuat database user");
                }

                let laravel_dir = resource_dir
                    .join("resources")
                    .join("laravel");

                let php = resource_dir
                    .join("binaries")
                    .join("php.exe");

                const CREATE_NO_WINDOW: u32 = 0x08000000;

                let php_process = std::process::Command::new(php)
                    .arg("artisan")
                    .arg("serve")
                    .arg("--host=127.0.0.1")
                    .arg("--port=8000")
                    .env("DB_CONNECTION", "sqlite")
                    .env("DB_DATABASE", &user_database)
                    .current_dir(laravel_dir)
                    .creation_flags(CREATE_NO_WINDOW)
                    .spawn()
                    .expect("Gagal menjalankan Laravel server");
                
                app.manage(PhpProcess(Mutex::new(Some(php_process))));
            }

                        Ok(())
        })
        .on_window_event(|window, event| {
            if let tauri::WindowEvent::Destroyed = event {
                use tauri::Manager;

                let state = window.state::<PhpProcess>();

                if let Ok(mut process) = state.0.lock() {
                    if let Some(mut child) = process.take() {
                        let _ = child.kill();
                        let _ = child.wait();
                    }
                };
            }
        })
        .run(tauri::generate_context!())
        .expect("error while running tauri application");
}