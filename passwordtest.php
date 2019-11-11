<?php

  $password_plain = "CorrectHorseBatteryStaple";

  $password_wrong = "correcthorsebatterystaple";

  $password_crypt = password_hash( $password_plain, PASSWORD_DEFAULT );

  echo " Password: $password_plain\n";
  echo "Encrypted: $password_crypt\n";

  echo "Breakdown:\n";
  echo "    Algorithm: " . substr($password_crypt,  1,  2) . "\n";
  echo "         Cost: " . substr($password_crypt,  4,  2) . "\n";
  echo "         Salt: " . substr($password_crypt,  7, 22) . "\n";
  echo "         Hash: " . substr($password_crypt, 29, 31) . "\n";

  echo "Encryption info:\n";
  print_r( password_get_info( $password_crypt ) );

  echo "\n$password_plain: ";
  if ( password_verify( $password_plain, $password_crypt ) ) {
      echo "    correct.\n";
  } else {
      echo "  incorrect.\n";
  }

  echo "\n$password_wrong: ";
  if ( password_verify( $password_wrong, $password_crypt ) ) {
      echo "    correct.\n";
  } else {
      echo "  incorrect.\n";
  }

?>
