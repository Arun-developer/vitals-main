<style>
#container1 {
    margin: 20px auto;
}

#content1 {
    float: left;
    width: 560px;
}

#sidebar1 {
    float: left;
    width: 300px;
}
</style>


<form class="uniform" action="applicantRequest_details.php">
    <dl class="inline">

        <dt><label for="name">Incubatee</label></dt>
        <dd>
            <input type="text" id="name" value="" class="medium required" size="50" />

        </dd>
        <dt><label for="name">Meeting Topic</label></dt>
        <dd>
            <input type="text" id="name" class="medium required" size="50" />
        </dd>

        <dt><label for="name">Meeting Date</label></dt>
        <dd>
            <input type="text" id="name" class="medium required" size="50" />
        </dd>
        <dt><label for="name">Mode of communication</label></dt>
        <dd>
            <input type="text" id="name" class="medium required" size="50" />
            <small> Telephone or Email</small>
        </dd>


    </dl>
    <div class="buttons">
        <input type="submit" value="Save" class="button" />
        <input type="reset" value="Reset" class="button white" />
    </div>
</form>
<div id="container1">
    <div id="content1">
        <table class="gtable sortable">
            <thead>
                <tr>
                    <td><b>Meeting Topic<b> :</td>
                    <td>Need to be discussed</td>
                </tr>
                <tr>
                    <td><b>Meeting Date<b></td>
                    <td> 24/3/2012 </td>
                </tr>
                <tr>
                    <td><b>Communication<b></td>
                    <td>Telephone </td>
                </tr>
            </thead>
        </table>
    </div>
    <div id="sidebar1">
        <table class="gtable sortable">
            <thead>
                <tr>
                    <td><b>Meeting Comments<b> :</td>
                    <td><a href="mentorComments.php" class="fancybox">Meeting</td>
                </tr>
                <tr>
                    <td><b>No of Hours Consumed<b></td>
                    <td> 4 </td>
                </tr>
                <tr>
                    <td><b>Email Reminder</b></td>
                    <td><a class="fancybox">Email</a></td>
                </tr>

            </thead>
        </table>
    </div>

    <br />
    <br />
    <br />

</div>