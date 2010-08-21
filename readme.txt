To use tuh simply include the class and call the parse method.

require('tuh.php');
print tuh::parse($text);

For trusted content such as blog posts you can disable the HTML protection (allowing all input) by disabling the dangerous flag.

print tuh::parse($text, FALSE);

However, it doesn't stop there. After you parse the text you can easily reverse the process using the unparse method! This makes it simple to add a edit feature to your application.

print tuh::unparse($html);

Also, make sure you UTf-8 encode the string to ensure proper support for other languages.

$comment = tuh::parse( tuh::to_utf8($_POST['comment']) );

David Pennington
http://xeoncross.com