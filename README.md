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