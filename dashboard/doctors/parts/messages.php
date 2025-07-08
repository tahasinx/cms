<div class="notification-box">
    <div class="msg-sidebar notifications msg-noti">
        <div class="topnav-dropdown-header">
            <span>Messages</span>
        </div>
        <div class="drop-scroll msg-list-scroll" id="msg_list">
            <ul class="list-box" id="messages">
                <?php
                $server = new Server();
                $mn = $server->message_notification();

                while ($info = $mn->fetch_assoc()) {
                    ?>
                    <li>
                        <a href="chat.php?message_to=<?= $info['notification_from'] ?>&status=1">
                            <div class="list-item">
                                <div class="list-left">
                                    <span class="avatar">
                                        <img src="<?= $server->getClient_ImageByID($info['notification_from']); ?>"  />
                                    </span>
                                </div>
                                <div class="list-body">
                                    <span class="message-author"><?= $server->getClient_NameByID($info['notification_from']) ?></span>
                                    <div class="clearfix"></div>
                                    <span class="message-content"><?= $info['notification_about'] ?></span>
                                    <small><?= $info['notification_time'] ?></small>
                                </div>
                            </div>
                        </a>
                    </li>
                <?php } ?>
            </ul>
        </div>
        <div class="topnav-dropdown-footer">
            <a href="chat.html">See all messages</a>
        </div>
    </div>
</div>