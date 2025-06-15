<?php
session_start();
include("db.php");

$is_logged_in = isset($_SESSION['user_id']);


$rss_urls = [
    "https://www.scholarshipsads.com/feed/",
    "https://opportunitiescorners.info/feed/",
];

$scholarships = [];
function fetchRSSData($url) {
    $items = [];
    try {
        $xml = @simplexml_load_file($url);
        if ($xml && isset($xml->channel->item)) {
            foreach ($xml->channel->item as $entry) {
                $items[] = [
                    'title' => (string) $entry->title,
                    'link' => (string) $entry->link,
                    'description' => strip_tags((string) $entry->description),
                    'pubDate' => (string) $entry->pubDate,
                    'source' => parse_url($url, PHP_URL_HOST)
                ];
            }
        }
    } catch (Exception $e) {
        
    }
    return $items;
}


foreach ($rss_urls as $rss_url) {
    $fetched = fetchRSSData($rss_url);
    $scholarships = array_merge($scholarships, $fetched);
}


$query = "SELECT title, description, link, pubDate, source FROM scholarships ORDER BY pubDate DESC";
$result = mysqli_query($conn, $query);
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $scholarships[] = [
            'title' => $row['title'],
            'description' => $row['description'],
            'link' => $row['link'],
            'pubDate' => $row['pubDate'],
            'source' => $row['source']
        ];
    }
}

usort($scholarships, function ($a, $b) {
    return strtotime($b['pubDate']) - strtotime($a['pubDate']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Scholarship Information Hub</title>
    <link rel="stylesheet" href="css\scholarship.css">
</head>
<body>
<div class="navbar">
  <div class="container">
    <h1 class="name">Virtual Study Buddy</h1>
    <nav>
      <ul>
        <li><a href="index.php" >Home</a></li>
        <li><a href="planner.php">Study Planner</a></li>
        <li><a href="scholarships.php" class="active" >Scholarships</a></li>
        <li><a href="groups.php">Study Groups</a></li>
        <li><a href="resources.php">Resources</a></li>
        <?php if ($is_logged_in): ?>
          <li><a href="dashboard.php">Dashboard</a></li>
          <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Sign Up</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</div>

<div class="container">
    <h2> Scholarship Information Hub</h2>
    <p>Fetched from both official platforms and our admin team to keep you updated with the latest opportunities.</p>

    <?php if (empty($scholarships)) : ?>
        <p>No scholarships found at the moment. Please try again later.</p>
    <?php else: ?>
        <?php foreach ($scholarships as $sch) : ?>
            <div class="card">
                <h3><?= htmlspecialchars($sch['title']) ?></h3>
                <p><?= htmlspecialchars($sch['description']) ?></p>
                <p><a href="<?= htmlspecialchars($sch['link']) ?>" target="_blank">Read more & Apply</a></p>
                <small> Published: <?= date("d M Y", strtotime($sch['pubDate'])) ?> | Source: <?= htmlspecialchars($sch['source']) ?></small>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
</body>
</html>
