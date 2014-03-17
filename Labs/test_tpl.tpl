<html>
	<head>
		<title>测试模板</tilte>
	</head>
	<body>
		<c:out value="'what'" />
		<c:out value="$hello" escape='true' />
		<c:if test="$a gt 5">
		</c:if>

		{$hello}
		{func:\Demo.ink.escape($abc, null)}
	</body>
	
</html>