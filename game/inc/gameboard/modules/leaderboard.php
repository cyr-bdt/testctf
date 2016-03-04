<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/../common/sessions.php');
require_once($_SERVER['DOCUMENT_ROOT'] . '/../common/teams.php');

sess_start();
sess_enforce_login();

$teams = new Teams();
$leaders = $teams->leaderboard();

$my_team = $teams->get_team(sess_team());

$my_name = htmlspecialchars($my_team['name']);
$my_points = $my_team['points'];
$my_rank = $teams->my_rank(sess_team());

echo <<< EOT
<header class="module-header">
  <h6>Leaderboard</h6>
</header>
<div class="module-content">
  <div class="fb-section-border">
    <div class="module-top player-info">
      <h5 class="player-name">{$my_name}</h5>
      <span class="player-rank">Rank {$my_rank}</span>
      <span class="player-score">{$my_points} Pts</span>
    </div>
    <div class="module-scrollable">
      <ul>
EOT;

$teams = new Teams();
$rank = 1;
$l_max = (sizeof($leaders) > 5) ? 5 : sizeof($leaders);
for($i = 0; $i<$l_max; $i++) {
  $team = $leaders[$i];
  $team_name = htmlspecialchars($team['name']);
  echo <<< EOT
        <li class="fb-user-card">
          <div class="user-avatar"><svg class="icon--badge"><use xlink:href="#icon--badge-{$team['logo']}"></use></svg></div>
          <div class="player-info">
            <h6>$team_name</h6>
            <span class="player-rank">Rank {$rank}</span>
            <span class="player-score">{$team['points']} pts</span>
          </div>
        </li>
EOT;
  $rank++;  
}

echo <<< EOT
      </ul>
    </div>
  </div>
</div>
EOT

?>