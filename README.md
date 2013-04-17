Tumblr Latest Photos
====================

Really simple class get get the latest photo posts from specified tumblr


Usage
-----
An Example

Gets 12 photos from picturedept.tumblr.com

```php
<?php
    $photos = new Tumblr_Latest_Photos( 'picturedept' );
    $latest_photos = $photos->generate('12');
```

Demo
----
[http://demo.jworksuk.com/github/tumblrlatestphotos/examples/basic-masonry.php](http://demo.jworksuk.com/github/tumblrlatestphotos/examples/basic-masonry.php)

TODO
----
Use `curl` instead of `file_get_contents` as some servers don't allow `file_get_contents`