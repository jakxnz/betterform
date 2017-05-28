<% loop $Options %>
    <label class="$Class radio-inline-container">
        <input id="$ID" class="$Class radio-inline" name="$Name" type="radio" value="$Value.ATT"<% if $isChecked %> checked<% end_if %><% if $isDisabled %> disabled<% end_if %> <% if $Up.Required %>required<% end_if %> />
        $Title
    </label>
<% end_loop %>
