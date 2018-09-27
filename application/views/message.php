<?php $lastMessage = $lastMessage[0]; ?>

<div class="message" data-id="<?=$lastMessage['id']?>">
  <?php if ($lastMessage['name'] == $_COOKIE['name']['name']): ?>
      <span class="delete" id="delete">&times;</span>
  <?php endif; ?>
  <h3 class="message-author"><?=htmlspecialchars($lastMessage['name'], ENT_QUOTES);?></h3>
  <div class="message-text"><?=htmlspecialchars($lastMessage['message'], ENT_QUOTES);?></div>
  <div class="message-info">
      <div class="message-info__like">
          <i class="fa fa-heart-o like" aria-hidden="true" data-id="<?=$lastMessage['id']?>"></i>
          <i class="fa fa-heart" aria-hidden="true" style="display: none;"></i>
          <span><?=$lastMessage['likes']?></span>
      </div>
      <div class="message-info__date"><?=$lastMessage['date']?></div>
  </div>
</div>