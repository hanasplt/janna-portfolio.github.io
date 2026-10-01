<?php
require __DIR__ . '/data.php';

$pages = ['home' => 'Home', 'about' => 'About Me', 'works' => 'Works'];
$page  = $_GET['page'] ?? 'home';
if (!isset($pages[$page])) { $page = 'home'; http_response_code(404); }

function e(string $s): string { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

// Uses assets/janna.jpg if you add one; otherwise shows a placeholder.
$photo = file_exists(__DIR__ . '/assets/janna.jpg') ? 'assets/janna.jpg' : null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($pages[$page]) ?> · <?= e($name) ?></title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Lilita+One&family=Montserrat:wght@400;500;600&family=Special+Elite&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="paper">

  <header class="topbar">
    <nav aria-label="Main">
      <?php foreach ($pages as $slug => $label): ?>
        <a href="?page=<?= $slug ?>" <?= $slug === $page ? 'aria-current="page"' : '' ?>><?= e($label) ?></a>
      <?php endforeach; ?>
    </nav>
    <time class="clock" id="clock" datetime="<?= date('c') ?>"><?= date('D, M j · g:i A') ?></time>
  </header>

<?php if ($page === 'home'): ?>

  <section class="hero" aria-label="Introduction">
    <p class="hey">Hey! It's</p>
    <h1 class="name"><?= e(strtoupper($name)) ?></h1>

    <a class="note n-design"    href="?page=works#design">I design</a>
    <a class="note n-create"    href="?page=works#create">I create</a>
    <a class="note n-imagine"   href="?page=about">I imagine</a>
    <a class="note n-visualize" href="?page=works#visualize">I visualize</a>

    <svg class="arrow a-design" viewBox="0 0 80 40" aria-hidden="true"><path d="M78 6 C50 -2 30 8 6 22 M6 22 l9 -1 M6 22 l5 -8"/></svg>
    <svg class="arrow a-create" viewBox="0 0 80 40" aria-hidden="true"><path d="M2 28 C20 28 40 20 70 8 M70 8 l-9 1 M70 8 l-4 8"/></svg>
    <svg class="arrow a-imagine" viewBox="0 0 40 60" aria-hidden="true"><path d="M8 2 C2 24 8 40 20 56 M20 56 l-8 -3 M20 56 l-1 -9"/></svg>
    <svg class="arrow a-visualize" viewBox="0 0 60 50" aria-hidden="true"><path d="M2 4 C10 34 30 44 56 44 M56 44 l-8 -6 M56 44 l-8 5"/></svg>
  </section>

  <section class="intro">
    <figure class="polaroid">
      <?php if ($photo): ?>
        <img src="<?= e($photo) ?>" alt="Portrait of <?= e($name) ?>">
      <?php else: ?>
        <div class="photo-ph">Add your photo as<br><code>assets/janna.jpg</code></div>
      <?php endif; ?>
    </figure>
    <div class="bio">
      <?php foreach ($bio as $p): ?><p><?= e($p) ?></p><?php endforeach; ?>
    </div>
  </section>

  <section class="cols">
    <div class="col" id="education">
      <h2>Education</h2>
      <ul class="edu">
        <?php foreach ($education as [$school, $course, $years]): ?>
          <li><strong><?= e($school) ?></strong><span><?= e($course) ?></span><em><?= e($years) ?></em></li>
        <?php endforeach; ?>
      </ul>
    </div>
    <div class="col" id="skills">
      <h2>Skills</h2>
      <ul class="skills">
        <?php foreach ($skills as [$label, $level, $tag]): ?>
          <li>
            <span class="lang"><?= e($label) ?>:</span>
            <span class="dots" role="img" aria-label="<?= $level ?> out of 5">
              <?php for ($i = 1; $i <= 5; $i++): ?><i class="<?= $i <= $level ? 'on' : '' ?>" style="--i:<?= $i ?>"></i><?php endfor; ?>
            </span>
            <span class="tag"><?= e($tag) ?></span>
          </li>
        <?php endforeach; ?>
      </ul>
    </div>
  </section>

<?php elseif ($page === 'about'): ?>

  <section class="page">
    <h2 class="page-title">About me</h2>
    <div class="intro">
      <figure class="polaroid">
        <?php if ($photo): ?><img src="<?= e($photo) ?>" alt="Portrait of <?= e($name) ?>">
        <?php else: ?><div class="photo-ph">Add your photo as<br><code>assets/janna.jpg</code></div><?php endif; ?>
      </figure>
      <div class="bio"><?php foreach ($bio as $p): ?><p><?= e($p) ?></p><?php endforeach; ?></div>
    </div>
  </section>

<?php else: ?>

  <section class="page">
    <h2 class="page-title">Works</h2>
    <p class="lead">Tap a piece to open it.</p>
    <div class="grid">
      <?php foreach ($works as $i => [$title, $cat, $img]): ?>
        <a class="card" href="#work-<?= $i ?>" style="--r:<?= [-2,1.5,-1,2,-1.5,1][$i % 6] ?>deg">
          <span class="thumb">
            <?php if ($img && file_exists(__DIR__ . "/assets/$img")): ?><img src="assets/<?= e($img) ?>" alt=""><?php endif; ?>
          </span>
          <strong><?= e($title) ?></strong><small><?= e($cat) ?></small>
        </a>
      <?php endforeach; ?>
    </div>

    <?php foreach ($works as $i => [$title, $cat, $img]): ?>
      <div class="lightbox" id="work-<?= $i ?>">
        <a class="close" href="#" aria-label="Close"></a>
        <figure>
          <?php if ($img && file_exists(__DIR__ . "/assets/$img")): ?><img src="assets/<?= e($img) ?>" alt="<?= e($title) ?>">
          <?php else: ?><div class="photo-ph">Add <code>assets/<?= e($img ?: 'your-file.jpg') ?></code></div><?php endif; ?>
          <figcaption><strong><?= e($title) ?></strong> — <?= e($cat) ?></figcaption>
        </figure>
      </div>
    <?php endforeach; ?>
  </section>

<?php endif; ?>

  <footer>© <?= date('Y') ?> <?= e($name) ?></footer>
</div>

<script>
// Optional: keeps the date/time ticking. The page works without it.
(function(){var c=document.getElementById('clock');if(!c)return;
setInterval(function(){var d=new Date();
c.textContent=d.toLocaleDateString('en-US',{weekday:'short',month:'short',day:'numeric'})+' · '+d.toLocaleTimeString('en-US',{hour:'numeric',minute:'2-digit'});},1000);})();
</script>
</body>
</html>
