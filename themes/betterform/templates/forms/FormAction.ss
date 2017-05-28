<div class="row">
    <div class="col-xs-12 col-sm-8 text-right">
        <% if $UseButtonTag %>
                <button $AttributesHTML>
                        <% if $ButtonContent %>$ButtonContent<% else %>$Title.XML<% end_if %>
                </button>
        <% else %>
                <input $AttributesHTML />
        <% end_if %>
    </div>
</div>