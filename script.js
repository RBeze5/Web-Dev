// Function to fetch anime data based on user input
function fetchAnimeData() {
  // Get user input from the search box
  const userInput = document.getElementById('search-input').value;

  // Construct the API URL based on user input
  const apiUrl = `https://api.jikan.moe/v4/anime?q=${userInput}`;

  // Send an AJAX request to the API
  const xhr = new XMLHttpRequest();
  xhr.open('GET', apiUrl, true);
  xhr.onload = function () {
    if (this.status === 200) {
      const response = JSON.parse(this.responseText);

      // Parse the JSON response and update the HTML content
      const animeData = response.data;
      let output = '';

      animeData.forEach((anime) => {
        output += `
          <div class="anime">
            <img src="${anime.image_url}" alt="${anime.title}">
            <h3>${anime.title}</h3>
            <p>${anime.synopsis}</p>
          </div>
        `;
      });

      // Update the HTML content with the fetched anime data
      document.getElementById('anime-list').innerHTML = output;
    }
  };
  xhr.send();
}

// Event listener for the search button
document.getElementById('search-btn').addEventListener('click', fetchAnimeData);
