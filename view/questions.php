<?php include('template/header.php');
$quest=get_questions($userId);
?>

    <h2>Questions for User with ID: <?php echo $userId; ?></h2>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Body</th>
        </tr>
        <?php foreach ($quest as $question) : ?>
            <tr>
                <td><?php echo $question['id']; ?></td>
                <td><?php echo $question['title']; ?></td>
                <td><?php echo $question['body']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <button type="button"><a href=".?action=display_new_question">Add Question</a> </button>
    <button type="button"><a href=".?action=display_login">Log OUT</a> </button>

<?php include('template/footer.php'); ?>