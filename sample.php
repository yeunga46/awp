<?php
    $now = time();
    setcookie("Read_Sample_At", $now, $now+10, "/~kilroy", "elvis.rowan.edu");
?>
<html>
<head><title>foo</title></head>

<body>
<p>

This is my page!

<?php echo "Hello world"; ?>

<p>

<h2> No HTML, and no breaks: </h2>
<hr>
<?php for ($i=0; $i<5; $i++) {
        echo $i;
      } ?>
<hr>

<?php
    class person_type {
      var $fname="Harry", $lname="Potter";
      function init($first, $last) {
        $this->fname = $first;
        $this->lname = $last;
      }
    }

    $person = new person_type;
    print "$person->fname $person->lname";
?>
<br>
<?php
    $person->init("Sirius", "Black");
    print "$person->fname $person->lname";
?>

<hr>

<?php
    while (list ($key, $value) = each ($_COOKIE)) {
        echo "_COOKIE[$key] = $value<br>\n";
    }

    echo "<p>";
    $userid = $_COOKIE["MyPage_UserNum"]; // get user number
    if (empty($userid)) {
        echo "I don't know who you are!\n";
    } else {
        echo "You are number $userid\n";
    }
?>


<hr>

<?php
    $word = "Hello";
    echo "$word \t world";
    echo "<hr>";
    echo '$word \t world';
    echo "<hr>";
?>

Now for the included footer:

<?php
    include "foot2.php";
?>
</body>
</html
