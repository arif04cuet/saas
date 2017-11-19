
<h5>Visitors</h5>

<table width="100%" border="0">
    <thead>
        <tr>
            <td width="200" bgcolor="#1AC414">  IP </td>
            <td height="2" width="400" bgcolor="#1AC414">User agent</td>
            <td height="2" width="169" bgcolor="#1AC414"> Date &amp; Time</td>
        </tr>
    </thead>
    <tbody>

    {% for visitor  in visitors %}
    <tr>
        <td bgcolor="#75D169">{{ visitor.ip_address }}</td>
        <td bgcolor="#75D169">{{ visitor.user_agent }}</td>
        <td bgcolor="#75D169">{{ visitor.datetime }}</td>
    </tr>
    {% endfor %}
    </tbody>
    <tfoot>
        <tr>
            <td bgcolor="#1AC414"> <strong> Total unique IP´s </strong> </td>
            <td bgcolor="#1AC414"> <strong> {{ totalips }} </strong> </td>
        </tr>
    </tfoot>
</table>
