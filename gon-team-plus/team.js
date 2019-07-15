//note that email_storage variable is prepended by 'nospam' to throw off bots. We start email substring at 6 to leave off the 'nospam' prefix
var email_length_nospam = email_storage.length;
var email = email_storage.substr(6,email_length_nospam);
var email_length = email.length;
var at = email.indexOf('@');
var email_name = email.substr(0,at);
var email_domain = email.substr((at+1),email_domain);
console.log(email_length_nospam,email);

jQuery('a#team-email').html(email_name+'@'+email_domain);
jQuery('a#team-email').attr('href','mailto:'+email);