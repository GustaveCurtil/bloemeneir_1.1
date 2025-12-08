    <section class="inloggen">
        <form action="login" method="post">
            @csrf
            <h3>aanmelden</h3>
            <fieldset>
                <label for="naam">naam:</label>
                <input type="text" name="naam" id="">
                <label for="wachtwoord">wachtwoord:</label>
                <input type="password" name="wachtwoord" id="">
            </fieldset>
            <input type="submit" value="inloggen">
        </form>
    </section>