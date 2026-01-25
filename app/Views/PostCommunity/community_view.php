<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Community Feed</title>
    <style>
        body { font-family: sans-serif; background: #f4f6f8; padding: 20px; }
        .container { max-width: 800px; margin: 0 auto; }
        .post-card { background: white; padding: 20px; border-radius: 10px; margin-bottom: 30px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 15px; }
        input, textarea, select { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 5px; box-sizing: border-box; }
        button { background: #5a67d8; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold; }
        .feed-item { background: white; border-radius: 10px; padding: 20px; margin-bottom: 15px; border-left: 5px solid #5a67d8; box-shadow: 0 1px 3px rgba(0,0,0,0.1); }
        .feed-meta { color: #888; font-size: 0.9em; margin-bottom: 10px; }
        .badge { background: #e2e8f0; padding: 3px 8px; border-radius: 4px; font-size: 0.8em; font-weight: bold; color: #4a5568; text-transform: uppercase; }
    </style>
</head>
<body>
<div class="container">
    <div class="post-card">
        <h2>Create a Post</h2>
        <form method="POST" action="store">
            <input type="text" name="title" placeholder="Title" required><br><br>
            <select name="post_type">
                <option value="experience">Experience</option>
                <option value="question">Question</option>
            </select><br><br>
            <textarea name="content" placeholder="Content" required></textarea><br><br>
            <button type="submit">Post</button>
        </form>
    </div>

    <h2>Feed</h2>
    <?php foreach ($posts as $post): ?>
        <div class="feed-item">
            <h3><?= htmlspecialchars($post->getTitle()) ?></h3>
            <p><?= htmlspecialchars(substr($post->getContent(), 0, 100)) ?>...</p>
            <a href="show/<?= $post->getId() ?>">View Full Post</a>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>