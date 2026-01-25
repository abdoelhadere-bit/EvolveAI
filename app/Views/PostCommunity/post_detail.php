<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($post->getTitle()) ?></title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; background: #f0f2f5; padding: 50px; }
        .post-container { max-width: 600px; margin: 0 auto; background: white; padding: 40px; border-radius: 15px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .success-banner { background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 20px; text-align: center; font-weight: bold; }
        .badge { background: #5a67d8; color: white; padding: 5px 12px; border-radius: 20px; font-size: 0.8rem; text-transform: uppercase; }
        h1 { margin-top: 15px; color: #1a202c; }
        .content { font-size: 1.1rem; line-height: 1.7; color: #4a5568; white-space: pre-wrap; }
        .btn-back { display: inline-block; margin-top: 30px; text-decoration: none; color: #5a67d8; font-weight: bold; }
    </style>
</head>
<body>

<div class="container">
    <h1><?= htmlspecialchars($post->getTitle()) ?></h1>
    <p>Type: <?= htmlspecialchars($post->getPostType()) ?></p>
    <hr>
    <p><?= nl2br(htmlspecialchars($post->getContent())) ?></p>
    <a href="../view">← Back to Feed</a>
</div>

</body>
</html>