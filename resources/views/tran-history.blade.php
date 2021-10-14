<html>
<head>
	<title></title>
</head>
<body style="padding-top: 40px; margin: 0 auto;">
	<table>
		<thead>
			<th>Wallet ID</th> 
			<th>Tran Ref</th>
			<th>Tran Token</th> 
			<th>Tran Date and Time</th>
			<th>Txn Amount</th>
			<th>Tran Status</th>
		</thead>
		<tbody>
			@foreach($tran as $txn)
			<tr>
				<td style="border-bottom: 2px solid #000;">{{ $txn->vice }}</td>
				<td style="border-bottom: 2px solid #000;">{{ $txn->ref }}</td>
				<td style="border-bottom: 2px solid #000;">{{ $txn->token }}</td>
				<td style="border-bottom: 2px solid #000;">{{ $txn->created_at }}</td>
				<td style="border-bottom: 2px solid #000;">{{ $txn->tran_amount }}</td>
				<td style="text-align: center; border-bottom: 2px solid #000;">{{ $txn->status }}</td> 
			</tr>
			@endforeach
		</tbody>
	</table>
	<br>
	<br>
	{{ $tran->links() }}
</body>
</html>