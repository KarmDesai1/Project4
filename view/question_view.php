<?php include('template/header.php');
?>
<h1> Question <?php echo get_username($userId);?></h1>
<table align="center">
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Body</th>
            <th>Skills</th>
            <th>Go back</th>
        </tr>

        <?php foreach($questionId as $question) : ?>

        <tr>
            <td><?php echo $question['id'];?></td>
            <td><?php echo $question['title'];?></td>
            <td><?php echo $question['body'];?></td>
            <td><?php echo $question['skills'];?></td>
            <td>
                <form>
                <input type="hidden" name="action" value="display_question">
                <input type="hidden" name="id" value="<?php echo $question['id'];?>">
                <input type="hidden" name="userId" value="<?php echo $userId ?>">
                <button><input type="submit" class="btn edit" value="Go Back"></button>
                </form>
            </td>
        </tr>
<?php endforeach;?>
    </table>
    <a href=".?action=display"><input type="button" value="LogOut"></a>
    </table>

<?php include('template/footer.php'); ?>