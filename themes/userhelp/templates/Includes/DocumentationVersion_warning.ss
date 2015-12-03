<div class="warningBox" id="outdated-release">
    <div class="warningBoxTop">
        <% loop VersionWarning %>
            <% if OutdatedRelease %>
                <p>This CMS user help guide is for version $Version of the SilverStripe CMS (an older version) and may not be maintained any more.</p>
            <% end_if %>
        <% end_loop %>
    </div>
</div>
