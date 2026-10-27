<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// content.skin.php를 통해 include되므로 _common.php, head, tail은 이미 처리됨
// 로그인 확인
if (!$is_member) {
    echo '<div class="wrap_blocked"><div class="empty"><p>로그인이 필요합니다.</p></div></div>';
    return;
}
?>
<style>
    body.has_subhd { padding-top: 40px; }
    .wrap_blocked { margin-top: 24px; padding: 0 20px; }
    .wrap_blocked .empty { text-align: center; padding: 60px 0; color: #9AA3B2; font-size: 14px; }
    .wrap_blocked ul { list-style: none; padding: 0; margin: 0; }
    .wrap_blocked ul li {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 0;
        border-bottom: 1px solid #E3E7EF;
    }
    .wrap_blocked ul li span { font-size: 15px; color: #C6C8C8; font-weight: 500; }
    .wrap_blocked ul li .btn_unblock {
        flex-shrink: 0;
        padding: 6px 14px;
        border: 1px solid #5268A5;
        border-radius: 4px;
        background: none;
        background: #5268A5;
        color:#fff;
        font-size: 13px;
        cursor: pointer;
    }
    @media (max-width: 720px) {
        body.has_subhd { padding-top: 35.5px; }
        .wrap_blocked { margin-top: 18px; padding: 0 16px; }
        .wrap_blocked ul li span { font-size: 13px; }
        .wrap_blocked ul li .btn_unblock { font-size: 12px; padding: 5px 10px; }
    }
</style>

<div class="sub_header">
    <div class="container">
        <button onclick="history.back()" class="arr_prev"></button>
        <h3>차단한 사용자</h3>
    </div>
</div>

<div class="wrap_blocked">
<?php
$block_list = array();
if (isset($g5['message_block_table'])) {
    $my_mb_id = sql_escape_string($member['mb_id']);
    $res = sql_query("
        SELECT block_mb_id, mb_datetime
          FROM {$g5['message_block_table']}
         WHERE mb_id = '{$my_mb_id}'
         ORDER BY mb_datetime DESC
    ");
    while ($res && $row = sql_fetch_array($res)) {
        $block_list[] = $row;
    }
}

if (empty($block_list)) {
    echo '<div class="empty"><p>차단한 사용자가 없습니다.</p></div>';
} else {
    echo '<ul id="blocked_user_list">';
    foreach ($block_list as $item) {
        $uid = htmlspecialchars($item['block_mb_id']);
        echo '<li data-block-mb-id="' . $uid . '">';
        echo '<span>' . $uid . '</span>';
        echo '<button type="button" class="btn_unblock" data-block-mb-id="' . $uid . '">차단해제</button>';
        echo '</li>';
    }
    echo '</ul>';
}
?>
</div>

<script>
$(function() {
    $(document).on('click', '.btn_unblock', function() {
        var $btn   = $(this);
        var mbId   = $btn.data('block-mb-id');

        if (!confirm('"' + mbId + '" 님의 차단을 해제하시겠습니까?')) return;

        $.ajax({
            url: '<?php echo G5_THEME_URL; ?>/act/unblock_message.php',
            type: 'POST',
            dataType: 'json',
            data: { block_mb_id: mbId },
            success: function(data) {
                if (data.result === 'success') {
                    var $li = $btn.closest('li');
                    $li.fadeOut(250, function() {
                        $(this).remove();
                        if ($('#blocked_user_list li').length === 0) {
                            $('#blocked_user_list').replaceWith(
                                '<div class="empty"><p>차단한 사용자가 없습니다.</p></div>'
                            );
                        }
                    });
                } else if (data.result === 'login') {
                    alert('로그인이 필요합니다.');
                } else {
                    alert(data.msg || '차단 해제에 실패했습니다.');
                }
            },
            error: function() {
                alert('서버 오류가 발생했습니다.');
            }
        });
    });
});
</script>
