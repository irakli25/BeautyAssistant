<?php
require_once '../include/header.php';
require_once '../lib/Kendo/Autoload.php';
?>

<!-- Load Promise Polyfill. Required by the DialogFlow Client API.-->
<script src="https://www.promisejs.org/polyfills/promise-6.1.0.js"></script>

<!-- Load DialogFlow Client API -->
<script src="https://cdn.rawgit.com/dialogflow/dialogflow-javascript-client/50e82e62/target/ApiAi.min.js"></script>

<?php
$chat = new \Kendo\UI\Chat('chat');

$button = new \Kendo\UI\ChatToolbarButton();
$button->name("restart")
       ->iconClass("k-icon k-i-reload");

$toolbar = new \Kendo\UI\ChatToolbar();
$toolbar->addButton($button)
        ->toggleable(true);

$chat->toolbar($toolbar);

$chat->post('function(args) { agent.postMessage(args.text); }')
     ->toolClick('function(e) { if(e.name === "restart") e.sender.postMessage("restart"); }');
?>

<div class="demo-section k-content">
    <?php echo $chat->render(); ?>
</div>

<style>
    .k-card > img.k-card-image {
        height: 134px;
        display: block;
    }
    .quoteCard span {
        display: block;
        float: right;
    }
</style>

<script>
    $(document).ready(function () {
        var chat = $("#chat").getKendoChat();
        window.agent = new DialogFlowAgent(chat);
    });

    var QUOTE_CARD_TEMPLATE = kendo.template(
            '<div class="k-card k-card-type-rich">' +
                '<p><strong>Your car insurance would be:</strong></p>' +
                '<div class="k-card-body quoteCard">' +
                    '<div><strong>Type:</strong>' +
                    '<span>#:coverage#</span></div>' +

                    '<div><strong>Car model:</strong>' +
                    '<span>#:make# #:model#</span></div>' +

                    '<div><strong>Car cost:</strong>' +
                    '<span>#:worth#</span></div>' +

                    '<div><strong>Start date:</strong>' +
                    '<span>#:startDate#</span></div>' +

                    '<hr/><div><strong>Total:</strong>' +
                    '<span>#=kendo.toString(premium, "0.00")#</span></div>' +
                '</div>' +
            '</div>'
        );
        kendo.chat.registerTemplate("quote", QUOTE_CARD_TEMPLATE);

        var PLAN_CARD_TEMPLATE = kendo.template(
            '<div class="k-card k-card-type-rich">' +
                '<div class="k-card-body quoteCard">' +

                    '# for (var i = 0; i < rows.length; i++) { #' +
                    '<div><strong>#:rows[i].text#: </strong>' +
                    '<span>#= kendo.toString(rows[i].value, "0.00") #</span></div>' +
                    '# } #' +

                    '<hr/><div><strong>Total:</strong>' +
                    '<span>#= kendo.toString(premium, "0.00") #</span></div>' +

                '</div>' +
            '</div>'
        );
        kendo.chat.registerTemplate("payment_plan", PLAN_CARD_TEMPLATE);
</script>

<script>
    window.DialogFlowAgent = kendo.Class.extend({
        init: function(chat) {
            this.chat = chat;
            this.userInfo = {
                id: "botty",
                iconUrl: "https://demos.telerik.com/kendo-ui/content/chat/InsuranceBot.png",
                name: "Botty McbotFace"
            };

            this.agent = new ApiAi.ApiAiClient({ accessToken: "280344fb165a461a8ccfef7e1bb47e65" });

            this.postEvent("Welcome");

            this._timestamp;
        },

        postEvent: function(event) {
            this.agent
                .eventRequest(event)
                .then($.proxy(this.onResponse, this));
        },

        postMessage: function(text) {
            this.agent
                .textRequest(text)
                .then($.proxy(this.onResponse, this));
        },

        onResponse: function(response) {
            this._timestamp = response.timestamp;

            if (response.result && response.result.fulfillment) {
                var fulfillment = response.result.fulfillment;
                var data = fulfillment.data;

                this.renderMessages(fulfillment.messages);

                if (data && data.null) {
                    this.renderAttachments(data.null);

                    this.renderSuggestedActions(data.null.suggestedActions);
                }
            }
        },

        renderMessages: function(messages) {
            var that = this;

            $(messages).each(function(index, message) {
                switch (message.type) {
                    case 0:
                        that.chat.renderMessage({ type: "text", text: message.speech, timestamp: that._timestamp }, that.userInfo);
                        break;
                    case 2:
                        that.renderSuggestedActions(message.replies.map(function(reply) { return { title: reply, value: reply }; }));
                        break;
                    default:
                }
            });

        },

        renderAttachments: function(data) {
            var that = this;
            data.attachments = $(data.attachments).map(function(index, attachment) {
                return {
                    contentType: attachment.type || "heroCard",
                    content: attachment
                };
            }).toArray();

            this.chat.renderAttachments(data, this.userInfo);
        },

        renderSuggestedActions: function(suggestedActions) {
            this.chat.renderSuggestedActions($(suggestedActions).toArray());
        }
    });
</script>

<?php require_once '../include/footer.php'; ?>