<?php

class Captcha {

  // Number of characters
  public $chars_number = 4;
  // Numbers (1), Letters (2), Letters & Numbers (3)
  public $string_type = 3;
  // Font Size
  public $font_size = 14;
  // Border Color (optional)
  public $border_color = '239, 239, 239';
  // Path to TrueType Font
  public $tt_font = 'arial.ttf';

  /* Show Captcha Image */

  public function show_image($width = 88, $height = 31) {
    if (isSet($this->tt_font)) {
      if (!file_exists($this->tt_font))
        exit('The path to the true type font is incorrect.');
    }

    if ($this->chars_number < 3)
      exit('The captcha code must have at least 3 characters');

    $string = $this->generate_string();

    $im = ImageCreate($width, $height);

    /* Set a White & Transparent Background Color */
    $bg = ImageColorAllocateAlpha($im, 255, 255, 255, 127); // (PHP 4 >= 4.3.2, PHP 5)
    ImageFill($im, 0, 0, $bg);

    /* Border Color */

    if ($this->border_color) {
      list($red, $green, $blue) = explode(',', $this->border_color);

      $border = ImageColorAllocate($im, $red, $green, $blue);
      ImageRectangle($im, 0, 0, $width - 1, $height - 1, $border);
    }

    $textcolor = ImageColorAllocate($im, 191, 120, 120);

    $y = 24;

    for ($i = 0; $i < $this->chars_number; $i++) {
      $char = $string[$i];

      $factor = 15;
      $x = ($factor * ($i + 1)) - 6;
      $angle = rand(1, 15);

      imagettftext($im, $this->font_size, $angle, $x, $y, $textcolor, $this->tt_font, $char);
    }

    $_SESSION['security_code'] = md5($string);

    /* Output the verification image */
    header("Content-type: image/png");
    ImagePNG($im);

    exit;
  }

  private function generate_string() {
    if ($this->string_type == 1) { // letters
      $array = range('A', 'Z');
    } else if ($this->string_type == 2) { // numbers
      $array = range(1, 9);
    } else { // letters & numbers
      $x = ceil($this->chars_number / 2);

      $array_one = array_rand(array_flip(range('A', 'Z')), $x);
      $array_two = array_rand(array_flip(range('a', 'z')), $x);
      if ($x <= 2)
        $x = $x - 1;
      $array_three = array_rand(array_flip(range(1, 9)), $this->chars_number - $x);

      $array = array_merge($array_one, $array_two, $array_three);
    }

    $rand_keys = array_rand($array, $this->chars_number);

    $string = '';

    foreach ($rand_keys as $key) {
      $string .= $array[$key];
    }

    return $string;
  }

}
