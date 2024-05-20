<div>
    <form action="/test" method="post" class="formajax">
        @csrf
        <div>
            <label>Haber Adı:</label>
            <input type="email" name="email" placeholder="Email">
        </div>
        <div>
            <input type="password" name="password" placeholder="Password">
        </div>
        <div>
            <button type="submit">Sign In</button>
        </div>
    </form>
</div>
