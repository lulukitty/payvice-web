@include('emails.layout.mailheader')   
<tr>
<td style='color: #000; background-color: #fff;' colspan='3' align='left'>
    <p>
        {{ $Body }}
    </p>
    <p>
        <table>
            
            <tr>
                <td>Status</td><td> {{ $data['status'] }}</td>
            </tr>
            <tr>
                <td>Message</td><td> {{ $data['message'] }}</td>
            </tr>
            <tr>
                <td>Description</td><td> {{ $data['description'] }}</td>
            </tr>
            <tr>
                <td>Date/Time Reported</td><td>{{ date("jS \of F Y, h:i:s A") }}</td>
            </tr>
            
        </table>
    </p>
</td>
</tr>
@include('emails.layout.mailfooter')   