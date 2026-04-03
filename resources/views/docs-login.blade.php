<!DOCTYPE html>
<html lang="tg">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Токени Swagger</title>
    <style>
        :root {
            --bg: #f5efe5;
            --panel: #fffaf2;
            --text: #1f2937;
            --muted: #6b7280;
            --line: #e5d5bd;
            --accent: #c86b3c;
            --accent-dark: #8f3f1b;
            --input: #fff;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family: Georgia, "Times New Roman", serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(200, 107, 60, 0.18), transparent 28%),
                radial-gradient(circle at bottom right, rgba(143, 63, 27, 0.16), transparent 26%),
                linear-gradient(135deg, #f8f1e7, #efe3d1);
            display: grid;
            place-items: center;
            padding: 24px;
        }

        .wrap {
            width: 100%;
            max-width: 980px;
            display: grid;
            grid-template-columns: 1.1fr 1fr;
            border: 1px solid var(--line);
            border-radius: 24px;
            overflow: hidden;
            background: var(--panel);
            box-shadow: 0 24px 80px rgba(70, 34, 16, 0.14);
        }

        .hero {
            padding: 48px;
            background:
                linear-gradient(180deg, rgba(200, 107, 60, 0.12), rgba(200, 107, 60, 0)),
                linear-gradient(160deg, #fff7ed, #f3e6d3);
        }

        .hero small {
            letter-spacing: 0.14em;
            text-transform: uppercase;
            color: var(--accent-dark);
        }

        .hero h1 {
            margin: 18px 0 14px;
            font-size: clamp(2rem, 4vw, 3.7rem);
            line-height: 0.95;
        }

        .panel {
            padding: 32px;
            background: rgba(255, 250, 242, 0.96);
        }

        .card {
            border: 1px solid var(--line);
            border-radius: 18px;
            padding: 20px;
            background: rgba(255, 255, 255, 0.72);
        }

        h2 {
            margin: 0 0 14px;
            font-size: 1.15rem;
        }

        label {
            display: block;
            margin: 12px 0 8px;
            font-size: 0.92rem;
            color: var(--muted);
        }

        input {
            width: 100%;
            border: 1px solid var(--line);
            border-radius: 12px;
            background: var(--input);
            padding: 12px 14px;
            font: inherit;
            color: var(--text);
        }

        button {
            margin-top: 16px;
            width: 100%;
            border: 0;
            border-radius: 999px;
            padding: 13px 18px;
            font: inherit;
            color: #fffaf5;
            background: linear-gradient(135deg, var(--accent), var(--accent-dark));
            cursor: pointer;
        }

        .error {
            margin-bottom: 16px;
            padding: 12px 14px;
            border-radius: 12px;
            border: 1px solid #ef4444;
            background: #fff1f2;
            color: #991b1b;
        }

        @media (max-width: 860px) {
            .wrap {
                grid-template-columns: 1fr;
            }

            .hero,
            .panel {
                padding: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="wrap">
        <section class="hero">
            <small>Shop API</small>
            <h1>Саҳифаи токени Swagger</h1>
        </section>

        <section class="panel">
            @if($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif

            <div class="card">
                <h2>Токени дастрасӣ</h2>
                <form method="POST" action="{{ route('docs.login.submit') }}">
                    @csrf
                    <input type="hidden" name="next" value="{{ $nextUrl }}">

                    <label for="access_token">Токен</label>
                    <input id="access_token" name="access_token" type="text" placeholder="swagger-secret-token" required>

                    <button type="submit">Кушодани Swagger</button>
                </form>
            </div>
        </section>
    </div>
</body>
</html>
