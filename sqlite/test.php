<?php

  $db = new PDO("sqlite:test.db");
  $db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  try {
    $db -> exec('create table foo (col_1 number, col_2 varchar2)');

    print ("Table foo created");

    print ("<p><a href='02_create_table.html'>Create table again</a> and receive an error");

  }
  catch(PDOException $e) {

    print ("exception " . $e->getMessage());

  }

  print ("<p><a href='03_insert_values.html'>Insert values</a> into table");

  try {
    $stmt_h = $db -> prepare ('insert into foo values (:val_1, :val_2)');

    $stmt_h -> bindParam(':val_1', $v1);
    $stmt_h -> bindParam(':val_2', $v2);

    $v1 = 1;
    $v2 ='one';
    $stmt_h -> execute();

    $v1 = 2;
    $v2 ='two';
    $stmt_h -> execute();

    $v1 = 3;
    $v2 ='three';
    $stmt_h -> execute();

    $v1 = 4;
    $v2 ='four';
    $stmt_h -> execute();

    $v1 = 5;
    $v2 ='five';
    $stmt_h -> execute();

  }
  catch(PDOException $e) {

    print ("exception " . $e->getMessage());
  
  }

  print ("<p><a href='04_select_values.html'>Select</a> the inserted values");

  try {

    $stmt_h = $db -> prepare('select * from foo where col_1 > :param_1 and col_2 like :param_2');

    $stmt_h -> execute(array(1, '%o%'));

    $res = $stmt_h -> fetchAll();


    print '<table>';
    foreach ($res as $row) {

      print '<tr><td>' . $row['col_1'] . '</td><td>' . $row['col_2'] . '</td></tr>';

    }
    print '</table>';

  }
  catch(PDOException $e) {

    print ("exception " . $e->getMessage());
  
  }

  print "<p><a href='99_clean_up.html'>clean up</a>";

  unlink('test.db');

  print "Database deleted, <a href='01_create_db.html'>start over</a>.";


?>