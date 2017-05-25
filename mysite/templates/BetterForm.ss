<h2>PHP Form Validation Example</h2>
<p><span class="error">* required field.</span></p>
<form method="post" action="$Link">
  Name: <input type="text" name="name" value="$Name">
  <span class="error">* $NameErr</span>
  <br><br>
  E-mail: <input type="text" name="email" value="$Email">
  <span class="error">* $EmailErr</span>
  <br><br>
  Website: <input type="text" name="website" value="$Website">
  <span class="error">$WebsiteErr</span>
  <br><br>
  Comment: <textarea name="comment" rows="5" cols="40">$Comment</textarea>
  <br><br>
  Gender:
  <input type="radio" name="gender" value="female"<% if $Gender == "female" %> checked<% end_if %>>Female
  <input type="radio" name="gender" value="male"<% if $Gender == "male" %> checked<% end_if %>>Male
  <span class="error">* $GenderErr</span>
  <br><br>
  <input type="submit" name="submit" value="Submit">
</form>

<h2>Your Input:</h2>
<p>$Name</p>
<p>$Email</p>
<p>$Website</p>
<p>$Comment</p>
<p><% if $Gender == "female" %>Female<% else_if $Gender == "male" %>Male<% end_if %></p>
