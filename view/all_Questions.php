<?php include('template/header.php');
//require 'model/question_db.php';
$questions=getAll_questions();
?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="vote">
        <input type="hidden" name="action" value="display_users">

    <h2>Questions for All Users</h2>

    <table class="table">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Body</th>
            <th>Skills</th>
            <th>View</th>
            <th>Delete</th>
        </tr>
        <?php foreach ($questions as $question) : ?>
            <tr>
                <td><?php echo $question['id']; ?></td>
                <td><?php echo $question['title']; ?></td>
                <td><?php echo $question['body']; ?></td>
                <td><?php echo $question['skills']; ?></td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="">
                        <input type="hidden" name="questionId" value="<?php echo $question['id'];?>">

                        <button><input type="submit" class="btn edit" value="View" ></button>
                    </form>
                </td>
                <td>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="delete_question">
                        <input type="hidden" name="questionId" value="<?php echo $question['id'];?>">


                        <button><input class="btn" type="submit" value="Delete"> </button>
                    </form>

                </td>
                <button type="submit" name="upvote" value=+1><img src="/images/upvote.png" style="width:30px;height:30px" alt="SomeAlternateTex"></button>
                <button type="submit" name="downvote" value=-1><img src="/images/downvote.png" style="width:30px;height:30px" alt="SomeAlternateText"></button>

            </tr>
        <?php endforeach; ?>
    </table>
    <button type="button"><a href=".?action=display_new_question">Add Question</a> </button>
    <button type="button"><a href=".?action=display_login">Delete Question</a> </button>
    <button type="button"><a href=".?action=display_login">Log OUT</a> </button>
    <button type="button"><<a href=".?action=display_questions<?php echo $userId; ?>"><a>User Questions</a></button>


<?php include('template/footer.php'); ?>