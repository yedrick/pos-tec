<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'POS Laravel')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* ── Reset & Base ─────────────────────────────────── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg-primary: #0f0f1a;
            --bg-card: rgba(255, 255, 255, 0.04);
            --bg-card-hover: rgba(255, 255, 255, 0.07);
            --border-subtle: rgba(255, 255, 255, 0.08);
            --text-primary: #e8e8ef;
            --text-secondary: #8b8ba0;
            --text-muted: #5a5a72;
            --accent: #6c5ce7;
            --accent-glow: rgba(108, 92, 231, 0.35);
            --accent-hover: #7c6ef0;
            --danger: #ff6b6b;
            --success: #51cf66;
            --radius: 12px;
            --radius-sm: 8px;
            --transition: 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background: var(--bg-primary);
            color: var(--text-primary);
            min-height: 100vh;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Animated background ──────────────────────────── */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background:
                radial-gradient(ellipse 600px 600px at 20% 20%, rgba(108, 92, 231, 0.08), transparent),
                radial-gradient(ellipse 500px 500px at 80% 80%, rgba(99, 110, 255, 0.06), transparent),
                radial-gradient(ellipse 400px 400px at 50% 50%, rgba(157, 78, 221, 0.04), transparent);
            animation: bgDrift 20s ease-in-out infinite alternate;
            z-index: -1;
            pointer-events: none;
        }

        @keyframes bgDrift {
            0%   { transform: translate(0, 0) rotate(0deg); }
            100% { transform: translate(-3%, -3%) rotate(3deg); }
        }

        /* ── Auth Layout (centrado) ───────────────────────── */
        .auth-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 2.5rem;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            animation: fadeSlideUp 0.5s ease-out;
        }

        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-card h1 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
            background: linear-gradient(135deg, var(--text-primary), var(--accent-hover));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .auth-card .subtitle {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

        /* ── Form Elements ────────────────────────────────── */
        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            font-size: 0.8rem;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: inherit;
            font-size: 0.95rem;
            transition: var(--transition);
            outline: none;
        }

        .form-group input::placeholder {
            color: var(--text-muted);
        }

        .form-group input:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
            background: rgba(255, 255, 255, 0.06);
        }

        .form-check {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .form-check input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .form-check label {
            font-size: 0.85rem;
            color: var(--text-secondary);
            cursor: pointer;
        }

        /* ── Buttons ──────────────────────────────────────── */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: var(--radius-sm);
            font-family: inherit;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--accent), #7c5cf0);
            color: #fff;
            box-shadow: 0 4px 20px var(--accent-glow);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--accent-hover), #8b6ff5);
            box-shadow: 0 6px 28px var(--accent-glow);
            transform: translateY(-1px);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-danger {
            background: rgba(255, 107, 107, 0.12);
            color: var(--danger);
            border: 1px solid rgba(255, 107, 107, 0.2);
        }

        .btn-danger:hover {
            background: rgba(255, 107, 107, 0.2);
        }

        /* ── Links ────────────────────────────────────────── */
        .auth-link {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        .auth-link a {
            color: var(--accent-hover);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
        }

        .auth-link a:hover {
            color: #fff;
            text-decoration: underline;
        }

        /* ── Alerts ───────────────────────────────────────── */
        .alert {
            padding: 0.75rem 1rem;
            border-radius: var(--radius-sm);
            font-size: 0.85rem;
            margin-bottom: 1.25rem;
            animation: fadeSlideUp 0.3s ease-out;
        }

        .alert-error {
            background: rgba(255, 107, 107, 0.1);
            border: 1px solid rgba(255, 107, 107, 0.2);
            color: var(--danger);
        }

        .alert-success {
            background: rgba(81, 207, 102, 0.1);
            border: 1px solid rgba(81, 207, 102, 0.2);
            color: var(--success);
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* ── Dashboard Layout ─────────────────────────────── */
        .dashboard-wrapper {
            min-height: 100vh;
            padding: 2rem;
        }

        .dashboard-nav {
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 900px;
            margin: 0 auto 2rem;
            padding: 1rem 1.5rem;
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            backdrop-filter: blur(20px);
        }

        .dashboard-nav .brand {
            font-weight: 700;
            font-size: 1.1rem;
            background: linear-gradient(135deg, var(--accent), var(--accent-hover));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dashboard-nav .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dashboard-nav .user-name {
            font-size: 0.9rem;
            color: var(--text-secondary);
        }

        .dashboard-nav .btn {
            width: auto;
            padding: 0.5rem 1rem;
            font-size: 0.8rem;
        }

        .dashboard-content {
            max-width: 900px;
            margin: 0 auto;
        }

        .welcome-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: 20px;
            padding: 3rem;
            text-align: center;
            backdrop-filter: blur(20px);
            animation: fadeSlideUp 0.5s ease-out;
        }

        .welcome-card .emoji {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .welcome-card h2 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .welcome-card p {
            color: var(--text-secondary);
            font-size: 0.95rem;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius);
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
        }

        .stat-card:hover {
            background: var(--bg-card-hover);
            border-color: rgba(108, 92, 231, 0.2);
            transform: translateY(-2px);
        }

        .stat-card .stat-value {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--accent-hover);
        }

        .stat-card .stat-label {
            font-size: 0.8rem;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-top: 0.25rem;
        }

        /* ── Responsive ───────────────────────────────────── */
        @media (max-width: 480px) {
            .auth-card { padding: 1.75rem; }
            .dashboard-nav { flex-direction: column; gap: 1rem; text-align: center; }
            .welcome-card { padding: 2rem 1.5rem; }
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
