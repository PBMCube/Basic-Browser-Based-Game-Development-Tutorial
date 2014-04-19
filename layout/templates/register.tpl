{include file="global_header.tpl"}

<form method="post">
  <div class="form-group">
    <label>Email address</label>
    <input type="email" name="email" class="form-control" placeholder="Enter email" required autofocus="autofocus" />
  </div>
  <div class="form-group">
    <label>Username</label>
    <input type="text" name="username" class="form-control" placeholder="Username" required />
  </div>
  <div class="form-group">
    <label>Password</label>
    <input type="password" name="password" class="form-control" placeholder="Password" required />
  </div>
  <input type="submit" class="btn btn-default" name="register" value="Create account" />
</form>

{include file="global_footer.tpl"}