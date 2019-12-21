<?php include('template/header.php');
$questions=get_questions($userId);
?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="vote">

    <h2>Questions for User with ID: <?php echo $userId; ?></h2>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Body</th>
        </tr>
        <?php foreach ($questions as $question) : ?>
            <tr>
                <td><?php echo $question['id']; ?></td>
                <td><?php echo $question['title']; ?></td>
                <td><?php echo $question['body']; ?></td>
                <button type="submit" name="upvote" value=+1><img src="/images/upvote.png" style="width:30px;height:30px" alt="SomeAlternateTex"></button>
                <button type="submit" name="downvote" value=-1><img src="/images/downvote.png" style="width:30px;height:30px" alt="SomeAlternateText"></button>
            </tr>
    </form>
        <?php endforeach; ?>
    </table>
    <button type="button"><a href=".?action=display_new_question">Add Question</a> </button>
    <button type="button"><a href=".?action=display_login">Delete Question</a> </button>
    <button type="button"><a href=".?action=display_login">Log OUT</a> </button>

<?php include('template/footer.php'); ?>