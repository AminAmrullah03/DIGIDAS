<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DIGIDAS — Tidak Ada Koneksi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap');
        * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Plus Jakarta Sans', sans-serif; }
        body {
            min-height: 100vh; display: flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #059669 100%);
            padding: 24px;
        }
        .card {
            background: #fff; border-radius: 24px; padding: 40px 32px;
            text-align: center; max-width: 360px; width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
        }
        .icon-wrap {
            width: 72px; height: 72px; border-radius: 20px;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
        }
        h1 { font-size: 1.25rem; font-weight: 700; color: #064e3b; margin-bottom: 10px; }
        p  { font-size: 0.875rem; color: #64748b; line-height: 1.6; margin-bottom: 24px; }
        .btn {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 12px 24px; border-radius: 12px;
            background: linear-gradient(135deg, #059669, #10b981);
            color: #fff; font-weight: 700; font-size: 0.9rem;
            border: none; cursor: pointer; text-decoration: none;
            box-shadow: 0 4px 16px rgba(16,185,129,0.3);
            transition: all 0.2s;
        }
        .btn:hover { transform: translateY(-1px); box-shadow: 0 6px 24px rgba(16,185,129,0.4); }
        .badge {
            display: inline-flex; align-items: center; gap: 6px;
            background: #ecfdf5; color: #059669;
            border: 1px solid #a7f3d0; border-radius: 999px;
            padding: 4px 12px; font-size: 0.75rem; font-weight: 600;
            margin-bottom: 20px;
        }
        .dot { width: 7px; height: 7px; border-radius: 50%; background: #ef4444; }
    </style>
</head>
<body>
    <div class="card">
        <div class="badge">
            <div class="dot"></div>
            Tidak Ada Koneksi
        </div>
        <div class="icon-wrap">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#10b981" style="width:36px;height:36px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l8.735 8.735m0 0a.374.374 0 11.53.53m-.53-.53l.53.53m0 0L21 21M14.652 9.348a3.75 3.75 0 010 5.304m2.121-7.425a6.75 6.75 0 010 9.546m2.121-11.667c3.808 3.807 3.808 9.98 0 13.788m-9.546-4.242a3.733 3.733 0 01-1.06-2.122m-1.061 4.243a6.75 6.75 0 01-1.974-4.243m-2.121 6.364a10.5 10.5 0 01-3.072-7.425m.243-5.852a10.5 10.5 0 0110.5-2.578"/>
            </svg>
        </div>
        <h1>DIGIDAS Offline</h1>
        <p>Sepertinya kamu tidak terhubung ke internet. Pastikan koneksi aktif lalu coba lagi.</p>
        <button class="btn" onclick="window.location.reload()">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:16px;height:16px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-4.566l3.181 3.182m0-4.991v4.990"/>
            </svg>
            Coba Lagi
        </button>
        <p style="margin-top:16px;font-size:0.75rem;color:#94a3b8;">DIGIDAS · Darus Sholah Jember</p>
    </div>
</body>
</html>