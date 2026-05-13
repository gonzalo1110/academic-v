<!DOCTYPE html>
<html lang="es" data-theme="itibb">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingresar — SisAcad</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            min-height: 100vh;
            background: #dbeafe;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: 'Inter', system-ui, sans-serif;
        }
        .wrapper {
            width: 100%;
            max-width: 880px;
            display: flex;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 12px 56px rgba(26,58,107,0.25);
            border: 1.5px solid #bfdbfe;
            min-height: 560px;
        }
        .left {
            width: 42%;
            background-color: #1a3a6b;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 56px 32px;
            position: relative;
            overflow: hidden;
        }
        .wm {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 1;
        }
        .wm img {
            width: 280px;
            height: 280px;
            object-fit: contain;
            opacity: 0.7;
            filter: brightness(1.1) saturate(1.5) drop-shadow(0 0 20px rgba(255,255,255,0.3));
        }
        .wm2 {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            pointer-events: none;
            z-index: 2;
        }
        .wm2 img {
            width: 200px;
            height: 200px;
            object-fit: contain;
            opacity: 0.06;
            margin-top: 60px;
        }
        .wave {
            position: absolute;
            right: -1px;
            top: 0;
            height: 100%;
            width: 56px;
            z-index: 3;
        }
        .panel-text {
            position: relative;
            z-index: 10;
            text-align: center;
            margin-top: 420px;
        }
        .panel-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 24px;
            font-weight: 700;
            color: white;
            margin-bottom: 8px;
            line-height: 1.3;
        }
        .panel-text h2 {
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.05em;
            font-weight: 600;
            color: #93c5fd;
            margin: 0;
            line-height: 1.3;
        }
        .right {
            flex: 1;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 48px 40px;
        }
        .logos-row {
            display: flex;
            gap: 14px;
            align-items: center;
            justify-content: center;
            margin-bottom: 22px;
        }
        .logo-bubble-dark {
            width: 58px;
            height: 58px;
            border-radius: 14px;
            background: #0f2347;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #2d5aa0;
            box-shadow: 0 2px 10px rgba(26,58,107,0.2);
        }
        .logo-bubble-dark img { width: 44px; height: 44px; object-fit: contain; }
        .logo-bubble-light {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #e2e8f0;
            box-shadow: 0 2px 8px rgba(26,58,107,0.1);
        }
        .logo-bubble-light img { width: 38px; height: 38px; object-fit: contain; }
        .form-title {
            font-family: 'Cinzel', serif;
            font-size: 24px;
            font-weight: 700;
            color: #1e293b;
            text-align: center;
            margin-bottom: 4px;
        }
        .form-sub {
            font-size: 13px;
            color: #1a3a6b;
            font-weight: 500;
            text-align: center;
            margin-bottom: 28px;
        }
        .field { margin-bottom: 16px; }
        .field label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 6px; }
        .field-inner { position: relative; }
        .field-icon { position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #94a3b8; display: flex; pointer-events: none; }
        .finput {
            width: 100%;
            padding: 12px 14px 12px 40px;
            border-radius: 12px;
            border: 1.5px solid #bfdbfe;
            background: #eff6ff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            font-family: inherit;
            transition: border-color .2s, background .2s;
        }
        .finput:focus { border-color: #1a3a6b; background: white; }
        .finput-pr { padding-right: 42px; }
        .eye-btn { position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #94a3b8; display: flex; padding: 0; }
        .check-row { display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }
        .check-row input { width: 16px; height: 16px; accent-color: #1a3a6b; cursor: pointer; }
        .check-row label { font-size: 13px; font-weight: 500; color: #1a3a6b; cursor: pointer; }
        .btn-in {
            width: 100%;
            padding: 14px;
            border-radius: 12px;
            background: #1a3a6b;
            color: white;
            font-size: 15px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            font-family: inherit;
            letter-spacing: .02em;
            transition: background .2s;
        }
        .btn-in:hover { background: #0f2347; }
        .err-box { margin-bottom: 16px; padding: 12px 16px; border-radius: 12px; background: #fee2e2; border: 1px solid #fca5a5; color: #991b1b; font-size: 13px; font-weight: 500; }
        .hint { margin-top: 18px; padding: 12px 16px; border-radius: 12px; background: #eff6ff; border: 1px solid #bfdbfe; }
        .hint p { font-size: 12px; color: #475569; line-height: 1.6; margin: 0; }
        .hint strong { color: #1a3a6b; }
        .hint code { font-family: monospace; font-weight: 600; color: #1a3a6b; }
        @media (max-width: 640px) {
            .left { display: none; }
            .right { padding: 36px 24px; }
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- PANEL IZQUIERDO: solo watermarks + texto --}}
    <div class="left">

        {{-- Marca de agua principal: ITIBB centrada --}}
        <div class="wm">
            <img src="{{ asset('images/ITIBB.png') }}" alt="">
        </div>
        

        {{-- Solo texto, sin logos --}}
        <div class="panel-text">
            <h1>Bienvenido a</h1>
            <h2>Portal Académico</h2>
        </div>

        {{-- Ola separadora derecha --}}
        

    </div>

    {{-- PANEL DERECHO: logos pequeños + formulario --}}
    <div class="right" style="position:relative;overflow:hidden;">
        {{-- Marca de agua informática detrás del formulario --}}
        <div style="position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);pointer-events:none;z-index:0;">
            <img src="{{ asset('images/informatica.png') }}" alt="" style="width:320px;height:320px;object-fit:contain;opacity:0.18;filter:saturate(1.8) brightness(1.1);">
        </div>



        <div style="position:relative;z-index:1;">
        <h2 class="form-title">Iniciar sesión</h2>
        <p class="form-sub">Ingresa con tu carnet de identidad</p>

        @if ($errors->any())
            <div class="err-box">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="field">
                <label>Carnet de Identidad</label>
                <div class="field-inner">
                    <span class="field-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z"/>
                        </svg>
                    </span>
                    <input type="text" name="ci" value="{{ old('ci') }}" placeholder="Ingresa tu CI" class="finput" autocomplete="username" required>
                </div>
            </div>

            <div class="field" x-data="{ show: false }">
                <label>Contraseña</label>
                <div class="field-inner">
                    <span class="field-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/>
                        </svg>
                    </span>
                    <input :type="show ? 'text' : 'password'" name="password" placeholder="Ingresa tu contraseña" class="finput finput-pr" autocomplete="current-password" required>
                    <button type="button" class="eye-btn" @click="show=!show">
                        <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.964-7.178z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <svg x-show="show" xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="check-row">
                <input type="checkbox" name="remember" id="remember">
                <label for="remember">Recordarme</label>
            </div>

            <button type="submit" class="btn-in">Ingresar</button>
        </form>

        <div class="hint">
            <p><strong>Contraseña inicial:</strong> 3 iniciales mayúsculas + CI completo</p>
            <p><code>ej: Juan Mamani López → JML8956231</code></p>
        </div>

    </div>
</div>
</body>
</html>
