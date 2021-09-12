function init () {
    fetch('/api/v1/players')
    .then(response => response.json())
    .catch(error => console.log(error))
    .then(data => drawContainer(data.Players));
}

function drawContainer (players) {
    let container = document.getElementById('container');
    let searchForm = container.children[0];
    container.textContent = '';
    container.appendChild(searchForm);
    players.forEach(player => {
        container.appendChild(drawPlayer(player));
    });
}

function drawPlayer (player) {
    let card = document.createElement('div');
    card.classList.add('m-4', 'mt-10', 'p-4', 'bg-gray-200', 'rounded', 'text-xl', 'text-center', 'font-bold', 'shadow');
    let img = document.createElement('img');
    img.classList.add('rounded-full', 'mx-auto', '-m-10', 'border-2', 'border-white');
    img.src = 'https://randomuser.me/api/portraits/men/' + Math.floor(Math.random() * 100) + '.jpg';
    img.alt = player.name;
    let name = document.createElement('p');
    name.classList.add('text-gray-600', 'pt-2', 'uppercase');
    name.textContent = player.name;
    let position = document.createElement('p');
    position.classList.add('text-2xl', 'text-gray-400');
    position.textContent = player.position;
    let div_text = document.createElement('div');
    div_text.classList.add('mt-10');
    div_text.appendChild(name);
    div_text.appendChild(position);
    card.appendChild(img);
    card.appendChild(div_text);
    return card;
}

function search_team(event)
{
    event.preventDefault();
    let teamForm = document.getElementById('teamForm');
    let team = teamForm.querySelector('input').value;
    fetch('/api/v1/teams', {
        method: "POST",
        body: JSON.stringify({
            page: 1,
            name: team
        })
    })
    .then(response => response.json())
    .catch(error => console.log(error))
    .then(data => drawContainer(data.Players));
}

init();