<?php
$isDark = $theme === 'dark';
$bgColor = $isDark ? '#1f2937' : '#f3f4f6';
$textColor = $isDark ? '#f9fafb' : '#111827';
$cardBg = $isDark ? '#111827' : '#ffffff';
$borderColor = $isDark ? '#374151' : '#d1d5db';
?>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: <?php echo $bgColor; ?>;
            color: <?php echo $textColor; ?>;
            padding: 40px 16px;
        }
        .container {
            max-width: 680px;
            margin: 0 auto;
            background: <?php echo $cardBg; ?>;
            border: 1px solid <?php echo $borderColor; ?>;
            border-radius: 8px;
            padding: 24px;
        }
        h1 {
            margin: 0 0 8px 0;
            font-size: 30px;
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
        .info {
            margin: 12px 0;
            padding: 12px 14px;
            background: <?php echo $isDark ? '#1f2937' : '#ffffff'; ?>;
            border: 1px solid <?php echo $isDark ? '#334155' : '#e2e8f0'; ?>;
            border-radius: 6px;
            font-size: 15px;
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
    <h1>Dashboard</h1>
    <p class="subtitle">You are logged in successfully.</p>
    <hr>

    <p class="info"><b>Welcome:</b> <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?></p>
    <p class="info"><b>Login Time:</b> <?php echo htmlspecialchars($loginTime, ENT_QUOTES, 'UTF-8'); ?></p>

    <p class="links">
        <a href="index.php?action=settings">Settings</a>
        <a href="index.php?action=logout">Logout</a>
    </p>
    </div>
</body>
</html>
