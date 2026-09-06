<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Print {{ $folder->nama }}</title>
    @vite('resources/css/print-folder.css')
</head>

<body>
    @foreach ($folder->suratJalans as $suratJalan)
        <div class="page">
            <div class="header">
                <div class="header-left">
                    <div class="merk">
                        MERK : {{ strtoupper($suratJalan->merk->nama) }}
                    </div>

                    <div class="judul">
                        SURAT JALAN
                    </div>
                </div>

                <div class="header-right">
                    <div>
                        SURABAYA, {{ $suratJalan->tanggal->format('d - m - Y') }}
                    </div>

                    <div class="mt">
                        Kepada Yth:
                    </div>

                    <div class="penerima">
                        {{ $suratJalan->penerima->nama }}
                    </div>
                    <div class="alamat">
                        {{ $suratJalan->penerima->alamat }}
                    </div>
                </div>
            </div>
            <table class="items-table">
                <thead>
                    <tr>
                        <th style="width: 100px;">Banyaknya</th>
                        <th>Nama Barang</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($suratJalan->items as $item)
                        <tr>
                            <td class="text-center">
                                {{ $item->jumlah }}
                            </td>

                            <td>
                                {{ $item->nama_barang }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="delivery-footer">
                <div class="signature">
                    <div>Pengirim,</div>

                    <div class="signature-space"></div>
                    <div class="signature-name">Jimi</div>
                    <div>( ____________________ )</div>
                </div>

                <div class="total-koli">
                    <div>Total Koli</div>

                    <div class="total-koli-value">
                        {{ $suratJalan->items->sum('jumlah') }}
                    </div>
                </div>

                <div class="signature">
                    <div>Penerima,</div>

                    <div class="signature-space"></div>

                    <div>( ____________________ )</div>
                </div>
            </div>
        </div>
    @endforeach
    @if ($folder->details->isNotEmpty())
        <div class="page">
            <h4 class="detail-title">
                Detail Barang Campuran
            </h4>

            <table class="detail-table">
                <thead>
                    <tr>
                        <th style="width: 10%;">Jumlah</th>
                        <th style="width: 40%;">Nama Barang</th>
                        <th style="width: 10%;">Jumlah</th>
                        <th style="width: 40%;">Nama Barang</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $details = $folder->details->values();
                        $half = (int) ceil($details->count() / 2);

                        $left = $details->slice(0, $half)->values();
                        $right = $details->slice($half)->values();

                        $maxRows = max($left->count(), $right->count(), 20);
                    @endphp

                    @for ($i = 0; $i < $maxRows; $i++)
                        <tr>
                            <td class="text-center">
                                {{ $left[$i]->jumlah ?? '' }}
                            </td>

                            <td>
                                {{ $left[$i]->nama_barang ?? '' }}
                            </td>

                            <td class="text-center">
                                {{ $right[$i]->jumlah ?? '' }}
                            </td>

                            <td>
                                {{ $right[$i]->nama_barang ?? '' }}
                            </td>
                        </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    @endif
</body>

</html>
