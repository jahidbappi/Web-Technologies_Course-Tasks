<?php
$isDark = $theme === 'dark';
$bgColor = $isDark ? '#1f2937' : '#f3f4f6';
$textColor = $isDark ? '#f9fafb' : '#111827';
$cardBg = $isDark ? '#111827' : '#ffffff';
$borderColor = $isDark ? '#374151' : '#d1d5db';
?>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
            padding: 24px 12px;
        }
        .container {
            max-width: 520px;
            margin: 0 auto;
            background: <?php echo $cardBg; ?>;
            border: 1px solid <?php echo $borderColor; ?>;
            border-radius: 8px;
            padding: 16px;
        }
        h1 {
            margin: 0 0 8px 0;
            font-size: 24px;
        }
        .subtitle {
            margin: 0 0 20px 0;
            color: <?php echo $isDark ? '#94a3b8' : '#475569'; ?>;
        }
        hr {
            border: none;
            border-top: 1px solid <?php echo $borderColor; ?>;
            margin: 16px 0 20px 0;
        }
        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 6px;
        }
        td {
            vertical-align: top;
            font-size: 16px;
        }
        .field {
            width: 100%;
            padding: 7px 9px;
            border-radius: 6px;
            border: 1px solid <?php echo $isDark ? '#475569' : '#cbd5e1'; ?>;
            background: <?php echo $isDark ? '#1f2937' : '#ffffff'; ?>;
            color: <?php echo $textColor; ?>;
            font-size: 14px;
        }
        .field:focus {
            outline: none;
            border-color: #2563eb;
        }
        .error {
            color: #ef4444;
            font-size: 14px;
            display: block;
            margin-top: 6px;
        }
        .general-error {
            color: #ef4444;
            background: <?php echo $isDark ? '#450a0a' : '#fee2e2'; ?>;
            border: 1px solid <?php echo $isDark ? '#7f1d1d' : '#fecaca'; ?>;
            padding: 10px 12px;
            border-radius: 10px;
            margin-bottom: 14px;
        }
        .btn {
            border: none;
            background: #2563eb;
            color: #ffffff;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
        }
        .links {
            margin-top: 18px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .links a {
            text-decoration: none;
            font-weight: 600;
            color: #ffffff;
            background: #2563eb;
            padding: 9px 12px;
            border-radius: 6px;
            display: inline-block;
            font-size: 14px;
        }
        .links a:hover {
            background: #1d4ed8;
        }
    </style>
</head>
<body>
    <div class="container">
    <h1>Login Form</h1>
    <p class="subtitle">Sign in with your registered email and password.</p>
    <hr>

    <?php if (!empty($errors['general'])): ?>
        <p class="general-error"><b><?php echo htmlspecialchars($errors['general'], ENT_QUOTES, 'UTF-8'); ?></b></p>
    <?php endif; ?>

    <form method="POST" action="index.php?action=login_submit">
        <table>
            <tr>
                <td>Email</td>
                <td>
                    <input class="field" type="text" name="email" value="<?php echo htmlspecialchars($old['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                    <span class="error"><?php echo htmlspecialchars($errors['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </td>
            </tr>
            <tr>
                <td>Password</td>
                <td>
                    <input class="field" type="password" name="password">
                    <span class="error"><?php echo htmlspecialchars($errors['password'] ?? '', ENT_QUOTES, 'UTF-8'); ?></span>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><button class="btn" type="submit">Login</button></td>
            </tr>
        </table>
    </form>

    <p class="links">
        <a href="index.php?action=register">Go to Register</a>
        <a href="index.php?action=settings">Settings</a>
    </p>
    </div>
</body>
</html>
