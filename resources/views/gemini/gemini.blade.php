@extends('layout.master1.master')
@section('title', 'Anggaran')
@section('geminiAI', 'active')

@section('content')

    @include('utils.notif')
    <style>
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }
        input, button {
            margin: 10px 0;
            padding: 10px;
            width: 100%;
            box-sizing: border-box;
        }
        #responseText {
            margin-top: 10px;
            white-space: pre-wrap;
        }
    </style>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Analyze Your Report</h6>
        </div>
        <div class="card-body">
            <div class="container">
                <h1>Google Gemini Chat</h1>
                <input type="text" id="inputText" placeholder="Enter your message here">
                <button id="sendButton">Send</button>
                <p id="responseText"></p>
            </div>
        </div>
    </div>

    <script>
        // Ganti dengan API key Anda
const API_KEY = 'AIzaSyCki7iVXywt-be2TEo6IZdhYKcPSA454Ls';

async function sendMessage() {
    const inputText = document.getElementById('inputText').value;
    const responseText = document.getElementById('responseText');
    
    const url = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${API_KEY}`;
    const data = {
        contents: [
            {
                parts: [
                    {
                        text: inputText
                    }
                ]
            }
        ]
    };

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        });
        
        const result = await response.json();
        
        // Log the entire result for debugging
        console.log('API Response:', result);
        
        // Check if the response structure matches the expected format and extract the text
        if (result && result.candidates && result.candidates.length > 0 
            && result.candidates[0].content && result.candidates[0].content.parts 
            && result.candidates[0].content.parts.length > 0) {
            const text = result.candidates[0].content.parts[0].text;
            responseText.innerText = text;
        } else {
            responseText.innerText = 'No valid response from API';
        }
    } catch (error) {
        responseText.innerText = 'Error: ' + error.message;
    }
}

// Tambahkan event listener ke tombol
document.getElementById('sendButton').addEventListener('click', sendMessage);

    </script>

@endsection
