<div class="container-chat">
    <h1>online chat</h1>
    <input type="button" value="написать" class="btn btn-submit" id="send">
    <div id="messages">
        
        <?php foreach ($messages as $message): ?>

          <div class="message" data-id="<?=$message['id']?>">
            <?php if ($message['name'] == $_COOKIE['name']['name']): ?>
                <span class="delete" id="delete">&times;</span>
            <?php endif; ?>
            <h3 class="message-author">
                <?=htmlspecialchars($message['name'], ENT_QUOTES);?>    
            </h3>
            <div class="message-text">
                <?=htmlspecialchars($message['message'], ENT_QUOTES);?>
            </div>
            <div class="message-info">
                <div class="message-info__like">
                    <i class="fa fa-heart-o like" aria-hidden="true" data-id="<?=$message['id']?>"></i>
                    <i class="fa fa-heart" aria-hidden="true" style="display: none;"></i>
                    <span><?=$message['likes']?></span>
                </div>
                <div class="message-info__date"><?=$message['date']?></div>
            </div>
          </div>
            
        <?php endforeach; ?>

    </div>

    <div class="loader" id="loader" style="display: none;"></div>     
    <div class="overlay" id="overlay" style="display: none;"></div>
    <div class="send-message" id="sendMessage" style="display: none;">
        <h2>отправить сообщение<span class="close" id="close">&times;</span></h2>
        <p id="error"></p>
        <form method="post" class="form" action="add">
            <textarea class="btn btn-input" rows="5" placeholder="Сообщение" name="message"></textarea>
            <input type="file" class="btn btn-input"/>
            <input type="button" value="отправить" class="btn btn-submit" id="sendBtn">
        </form>
    </div>

</div>