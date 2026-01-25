<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post->getTitle()) ?></title>
    <style>
        :root { --primary: #6366f1; --bg: #f8fafc; --text: #1e293b; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); line-height: 1.8; margin: 0; padding: 60px 20px; }
        .post-container { max-width: 650px; margin: 0 auto; background: white; padding: 40px; border-radius: 16px; box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1); }
        .back-btn { text-decoration: none; color: var(--primary); font-weight: 600; font-size: 14px; display: inline-block; margin-bottom: 20px; }
        .badge { background: #eef2ff; color: var(--primary); padding: 4px 12px; border-radius: 9999px; font-size: 12px; font-weight: 700; text-transform: uppercase; }
        h1 { font-size: 2.25rem; font-weight: 800; line-height: 1.2; margin: 16px 0; color: #0f172a; }
        .meta { color: #64748b; font-size: 14px; margin-bottom: 30px; display: flex; gap: 15px; }
        .content { font-size: 18px; color: #334155; white-space: pre-wrap; }
        hr { border: 0; border-top: 1px solid #e2e8f0; margin: 40px 0; }
    </style>
</head>
<body>

<div class="post-container">
    <a href="../view" class="back-btn">← Back to Feed</a>
    <br>
    <span class="badge"><?= htmlspecialchars($post->getPostType()) ?></span>
    <h1><?= htmlspecialchars($post->getTitle()) ?></h1>
    
    <div class="meta">
        <span>By User #<?= $post->getUserId() ?></span>
        <span>•</span>
        <span>Published <?= $post->getCreatedAt() ?></span>
    </div>

    <div class="content">
        <?= nl2br(htmlspecialchars($post->getContent())) ?>
    </div>

    <hr>
    <p style="text-align: center; color: #94a3b8; font-size: 14px;">End of post</p>
</div>

</body>
</html>