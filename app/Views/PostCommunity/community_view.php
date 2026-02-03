<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Feed</title>
    <style>
        :root {
            --primary: #6366f1;
            --primary-dark: #4f46e5;
            --bg: #f8fafc;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --card-bg: #ffffff;
        }
        body { font-family: 'Inter', system-ui, sans-serif; background: var(--bg); color: var(--text-main); line-height: 1.5; margin: 0; padding: 40px 20px; }
        .container { max-width: 700px; margin: 0 auto; }
        
        /* Form Styling */
        .post-form-card { background: var(--card-bg); padding: 24px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1); margin-bottom: 40px; }
        .post-form-card h2 { margin-top: 0; font-size: 1.25rem; font-weight: 700; }
        input, select, textarea { 
            width: 100%; padding: 12px; margin-top: 8px; border: 1px solid #e2e8f0; border-radius: 8px; font-size: 14px; box-sizing: border-box; transition: border-color 0.2s;
        }
        input:focus, textarea:focus { outline: none; border-color: var(--primary); ring: 2px var(--primary); }
        button { 
            background: var(--primary); color: white; border: none; padding: 12px 24px; border-radius: 8px; font-weight: 600; cursor: pointer; transition: background 0.2s; margin-top: 10px; width: 100%;
        }
        button:hover { background: var(--primary-dark); }

        /* Feed Styling */
        .feed-header { font-size: 1.5rem; font-weight: 800; margin-bottom: 20px; color: var(--text-main); }
        .feed-item { 
            background: var(--card-bg); border-radius: 12px; padding: 24px; margin-bottom: 20px; 
            box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1); transition: transform 0.2s, box-shadow 0.2s;
            text-decoration: none; display: block; color: inherit;
        }
        .feed-item:hover { transform: translateY(-2px); box-shadow: 0 10px 15px -3px rgb(0 0 0 / 0.1); }
        
        .badge { 
            display: inline-block; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;
            background: #eef2ff; color: var(--primary); margin-bottom: 12px;
        }
        .feed-item h3 { margin: 0 0 8px 0; font-size: 1.2rem; }
        .feed-item p { color: var(--text-muted); margin: 0 0 16px 0; font-size: 15px; }
        .feed-meta { display: flex; align-items: center; font-size: 13px; color: var(--text-muted); border-top: 1px solid #f1f5f9; padding-top: 12px; }
    </style>
</head>
<body>

<div class="container">
    <div class="post-form-card">
        <h2>What's on your mind?</h2>
        <form method="POST" action="store">
            <input type="text" name="title" placeholder="Catchy title..." required>
            <select name="post_type">
                <option value="experience">💡 Share Experience</option>
                <option value="question">❓ Ask Question</option>
                <option value="advice">⭐ Give Advice</option>
            </select>
            <textarea name="content" rows="3" placeholder="Write your post here..." required></textarea>
            <button type="submit">Post to Community</button>
        </form>
    </div>

    <div class="feed-header">Community Feed</div>

    <?php if (empty($posts)): ?>
        <p style="text-align: center; color: var(--text-muted);">No posts yet. Be the first!</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <a href="show/<?= $post->getId() ?>" class="feed-item">
                <span class="badge"><?= htmlspecialchars($post->getPostType()) ?></span>
                <h3><?= htmlspecialchars($post->getTitle()) ?></h3>
                <p><?= htmlspecialchars(substr($post->getContent(), 0, 140)) ?>...</p>
                <div class="feed-meta">
                    <span>Posted by User #<?= $post->getUserId() ?></span>
                    <span style="margin: 0 8px;">•</span>
                    <span>Just now</span>
                </div>
            </a>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

</body>
</html>