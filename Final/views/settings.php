<?php
$isDark = $theme === 'dark';
$bgColor = $isDark ? '#1f2937' : '#f3f4f6';
$textColor = $isDark ? '#f9fafb' : '#111827';
$cardBg = $isDark ? '#111827' : '#ffffff';
$borderColor = $isDark ? '#374151' : '#d1d5db';
?>
<html>
<head>
    <title>Settings</title>
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
        }
        td {
            font-size: 16px;
        }
        select {
            width: 100%;
            padding: 7px 9px;
            border-radius: 6px;
            border: 1px solid <?php echo $isDark ? '#475569' : '#cbd5e1'; ?>;
            background: <?php echo $isDark ? '#1f2937' : '#ffffff'; ?>;
            color: <?php echo $textColor; ?>;
            font-size: 14px;
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
        .note {
            margin-top: 14px;
            color: <?php echo $isDark ? '#cbd5e1' : '#334155'; ?>;
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
    <h1>Theme Settings</h1>
    <p class="subtitle">Choose how the app looks on every page.</p>
    <hr>

    <form method="POST" action="index.php?action=save_settings">
        <table cellpadding="6">
            <tr>
                <td>Choose Theme</td>
                <td>
                    <select id="theme" name="theme">
                        <option value="light" <?php echo $theme === 'light' ? 'selected' : ''; ?>>Light</option>
                        <option value="dark" <?php echo $theme === 'dark' ? 'selected' : ''; ?>>Dark</option>
                    </select>
                </td>
                <td><button class="btn" type="submit">Save</button></td>
            </tr>
        </table>
    </form>

    <p class="note">Cookie expiry: 30 days</p>

    <p class="links">
        <a href="index.php?action=register">Register</a>
        <a href="index.php?action=login">Login</a>
        <?php if (!empty($_SESSION['user'])): ?>
            <a href="index.php?action=dashboard">Dashboard</a>
        <?php endif; ?>
    </p>
    </div>
</body>
</html>
