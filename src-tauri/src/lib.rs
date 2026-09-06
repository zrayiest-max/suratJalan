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

                let laravel_dir = resource_dir
                    .join("resources")
                    .join("laravel");

                let php = resource_dir
                    .join("binaries")
                    .join("php.exe");

                const CREATE_NO_WINDOW: u32 = 0x08000000;

                std::process::Command::new(php)
                    .arg("artisan")
                    .arg("serve")
                    .arg("--host=127.0.0.1")
                    .arg("--port=8000")
                    .current_dir(laravel_dir)
                    .creation_flags(CREATE_NO_WINDOW)
                    .spawn()
                    .expect("Gagal menjalankan Laravel server");
            }

            Ok(())
        })
        .run(tauri::generate_context!())
        .expect("error while running tauri application");
}