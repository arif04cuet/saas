<h5>Hits</h5>
<table width="100%" border="0">
    <thead>
        <tr>
            <td height="2" width="400" bgcolor="#1AC414">Page</td>
            <td height="2" width="169" bgcolor="#1AC414"> Hits</td>
        </tr>
    </thead>
    <tbody>

    {% for hit  in hits %}
        <tr>
            <td bgcolor="#75D169">{{ hit.page }}</td>
            <td bgcolor="#75D169">{{ hit.count }}</td>
        </tr>
    {% endfor %}
    </tbody>
    <tfoot>
        <tr>
            <td bgcolor="#1AC414"> <strong> Total Hits </strong> </td>
            <td bgcolor="#1AC414"> <strong> {{ totalhits }} </strong> </td></tr>
    </tfoot>
</table>

