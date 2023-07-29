$(document).ready(function() {
    // Show/hide chatbot container
    $("#chatbotContainer").hide();
    $("#chatbotIcon").click(function() {
        $("#chatbotContainer").slideToggle();
        $(".floating-text").slideToggle();
        $("#span").css("display", "block");
        $("#ikonic").slideToggle();

    });

    // Handle user input
    function handleUserInput() {
        var message = $("#chatbotInput").val();
        $("#chatbotInput").val("");
        displayUserMessage(message);
        processUserMessage(message);
    }

    $("#chatbotInput").keypress(function(event) {
        if (event.which == 13) { // Enter key
            handleUserInput();
        }
    });

    // Bind send button click event to handleUserInput function
    $("#sendButton").click(handleUserInput);

    // Display bot message
    function displayBotMessage(message) {
        var botMessage = '<div class="chatbot-message chatbot-bot">' + message + '</div>';
        $("#chatbotBody").append(botMessage);
        scrollToBottom();
    }

    // Display user message
    function displayUserMessage(message) {
        var userMessage = '<div class="chatbot-message chatbot-user">' + message + '</div>';
        $("#chatbotBody").append(userMessage);
        scrollToBottom();
    }

    // Scroll to the bottom of the chatbot body
    function scrollToBottom() {
        var chatbotBody = document.getElementById("chatbotBody");
        chatbotBody.scrollTop = chatbotBody.scrollHeight;
    }

    // Process user message
    function processUserMessage(message) {
        message = message.toLowerCase();

        if (message.includes("assistance") || message.includes("problem")) {
            var response = chatbotMessages["help"];
            displayBotMessage(response);
            return;
        }

        // Add more processing logic for user messages here

        if (message.includes("computer won't start")) {
            var response = chatbotMessages["computer-wont-start"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("screen is blank")) {
            var response = chatbotMessages["screen-is-blank"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("abnormally functioning operating system") || message.includes("software")) {
            var response = chatbotMessages["abnormally-functioning-operating-system"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("windows won't boot")) {
            var response = chatbotMessages["windows-wont-boot"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("desk") || message.includes("tekrem")) {
            var response = chatbotMessages["tekrem"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("name") || message.includes("who are you")) {
            var response = chatbotMessages["name"];
            displayBotMessage(response);
            return;
        }


        if (message.includes("wow") || message.includes("dope") || message.includes("Speechless")) {
            var response = chatbotMessages["wow"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("joseph") || message.includes("hanniel") || message.includes("who made you") || message.includes("where did you come from")) {
            var response = chatbotMessages["joseph"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("hate") || message.includes("forget it") || message.includes("nevermind") || message.includes("whatever") || message.includes("not helping") || message.includes("not helpful")) {
            var response = chatbotMessages["hate"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("hello") || message.includes("evening") || message.includes("afternoon") || message.includes("morning") || message.includes("whatsapp") || message.includes("whatsup") || message.includes("what's up") || message.includes("how are you") || message.includes("hi")) {
            var response = chatbotMessages["hello"];
            displayBotMessage(response);
            return;
        }


        if (message.includes("money") || message.includes("cash")) {
            var response = chatbotMessages["money"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("love") || message.includes("like you")) {
            var response = chatbotMessages["love"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("live") || message.includes("stay")) {
            var response = chatbotMessages["live"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("frozen") || message.includes("freezing") || message.includes("my computer is not responding")) {
            var response = chatbotMessages["screen-is-frozen"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("thank") || message.includes("okay") || message.includes("ok") || message.includes("amazing") || message.includes("nice") || message.includes("wonderful")) {
            var response = "You are welome and I'm glad to help! feel free to ask me for any assistance";
            displayBotMessage(response);
            return;
        }

        if (message.includes("computer is slow") || message.includes("pc is slow") || message.includes("taking too long to respond")) {
            var response = chatbotMessages["computer-is-slow"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("strange noises")) {
            var response = chatbotMessages["strange-noises"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("internet") || message.includes("connect to the internet")) {
            var response = chatbotMessages["internet"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("failing to start my computer") || message.includes("failing to start") || message.includes("power is not resonding") || message.includes("how do I start computer")) {
            var response = chatbotMessages["power"];
            displayBotMessage(response);
            return;
        }
        if (message.includes("mouse")) {
            var response = chatbotMessages["mouse"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("keyboard")) {
            var response = chatbotMessages["keyboard"];
            displayBotMessage(response);
            return;
        }
        if (message.includes("network")) {
            var response = chatbotMessages["network"];
            displayBotMessage(response);
            return;
        }
        if (message.includes("printer")) {
            var response = chatbotMessages["printer"];
            displayBotMessage(response);
            return;
        }

        if (message.includes("overheating")) {
            var response = chatbotMessages["overheating"];
            displayBotMessage(response);
            return;
        }


        if (message.includes("dropped internet connections")) {
            var response = chatbotMessages["dropped-internet-connections"];
            displayBotMessage(response);
            return;
        }



        var response = "I'm sorry, but I couldn't understand your question. Please provide more specific information or try asking a different question.";
        displayBotMessage(response);
    }

});