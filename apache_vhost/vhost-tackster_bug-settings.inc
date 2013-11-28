
#DO NOT EVER REMOVE THESE <Directory> DIRECTIVES
<Directory />
	#Options FollowSymLinks -Indexes -Includes -ExecCGI None
	Options FollowSymLinks +Indexes +Includes +ExecCGI None
	AllowOverride None

	AddHandler cgi-script .cgi
	DirectoryIndex index.cgi index.html
</Directory>
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
# Limit large requests
#limit upload request to 512k
LimitRequestBody 524288




