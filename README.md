GingerLight
==========

PHP wrapper for correcting spelling and grammar mistakes based on the context of complete sentences.

## Requirements

GingerLight works with PHP 5.3.3 or later.

## Usage

```php
$text   = 'The smelt of fliwers bring back memories.';
$parser = new GingerLight\Parser();
$result = $parser->parse($text);
print_r($result);
```

```
# output:

array(3) {
  'text'           => "The smelt of fliwers bring back memories."
  'result'         => "The smell of flowers brings back memories."
  'corrections' => array(3) {
    [0] => array(5) {
      'text'       => "smelt"
      'correct'    => "smell"
      'definition' => ""
      'start'      => 4
      'length'     => 5
    }
    [1] => array(5) {
      'text'       => "fliwers"
      'correct'    => "flowers"
      'definition' => "a plant cultivated for its blooms or blossoms"
      'start'      => 13
      'length'     => 7
    }
    [2] => array(5) {
      'text'       => "bring"
      'correct'    => "brings"
      'definition' => ""
      'start'      => 21
      'length'     => 5
    }
  }
}
```

## Contributing

1. Fork it
2. Create your feature branch (`git checkout -b my-new-feature`)
3. Commit your changes (`git commit -am 'Add some feature'`)
4. Push to the branch (`git push origin my-new-feature`)
5. Create new Pull Request

## Thanks

Thank you for [Ginger Proofreader] for such awesome service. Hope they will keep it free :)

Thanks to @subosito for this inspriration https://github.com/subosito/gingerice (Ruby Gem)
