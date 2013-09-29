#DO NOT EVER REMOVE THESE <Directory> DIRECTIVES
<Directory />
	#Options FollowSymLinks -Indexes -Includes -ExecCGI None
	Options FollowSymLinks +Indexes +Includes -ExecCGI None
	AllowOverride None
</Directory>

<Location /includes/>
	Order deny,allow
	Deny from all
</Location>

<IfModule !php5_module>
	<Directory />
		Options FollowSymLinks -Indexes -Includes -ExecCGI None
		AllowOverride None

		#####
		# PHP Module Not Available
		#Do not allow access to webserver since PHP isn't available

		#TODO: Replace with rewrite tool to maintenance site rather than an auth request.

		Order deny,allow
		Deny from all
	</Directory>
</IfModule>




#####
# Error Documents
# 404 is redirected to FURL
#ErrorDocument	404 /app/url-redirect.php
#ErrorDocument	400 /error/HTTP_BAD_REQUEST.html
#ErrorDocument	401 /error/HTTP_UNAUTHORIZED.html
#ErrorDocument	403 /error/HTTP_FORBIDDEN.html
##TODO: FURL needs to reco a 403 redirect and serve the correct page
#ErrorDocument	403 /app/url-redirect.php
#ErrorDocument	405 /error/HTTP_METHOD_NOT_ALLOWED.html
#ErrorDocument	408 /error/HTTP_REQUEST_TIME_OUT.html
#ErrorDocument	413 /error/HTTP_REQUEST_ENTITY_TOO_LARGE.html
#ErrorDocument	414 /error/HTTP_REQUEST_URI_TOO_LARGE.html
#ErrorDocument	500 /error/HTTP_INTERNAL_SERVER_ERROR.html
#ErrorDocument	502 /error/HTTP_BAD_GATEWAY.html
#ErrorDocument	503 /error/HTTP_SERVICE_UNAVAILABLE.html




#####
# Limit large requests
#limit upload request to 512k
LimitRequestBody 524288


