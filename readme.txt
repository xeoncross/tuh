To use tuh simply include the class and call the parse method.

require('tuh.php');
print tuh::parse($text);

For trusted content such as blog posts you can disable the HTML protection (allowing all input) by disabling the dangerous flag.

print tuh::parse($text, $dangerous = FALSE);

Have fun!

David Pennington
http://xeoncross.com