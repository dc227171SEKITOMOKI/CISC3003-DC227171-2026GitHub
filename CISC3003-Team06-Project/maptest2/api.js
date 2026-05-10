
const API_BASE_URL = '../api'; 

// 1. 获取全局排行榜数据
async function fetchLeaderboardData() {
    const tbody = document.getElementById("leaderboardBody");
    if (!tbody) return;

    tbody.innerHTML = "<tr><td colspan='4'>Loading ranking data...</td></tr>";

    try {
        // 解除注释，使用真实的 API 请求
        const response = await fetch(`${API_BASE_URL}/get_leaderboard.php`);
        if (!response.ok) throw new Error('Network response was not ok');
        const data = await response.json();

        renderLeaderboard(data);
    } catch (error) {
        console.error("Failed to fetch leaderboard:", error);
        tbody.innerHTML = "<tr><td colspan='4' style='color:#f38073;'>Failed to load ranking. Please try again later.</td></tr>";
    }
}


function renderLeaderboard(data) {
    const tbody = document.getElementById("leaderboardBody");
    if (!tbody) return;
    
    tbody.innerHTML = ""; 

    data.forEach(item => {
        const tr = document.createElement("tr");
        tr.innerHTML = `
            <td>${item.rank}</td>
            <td>${item.player_id}</td>
            <td>${item.level}</td>
            <td>${item.score}</td>
        `;
        tbody.appendChild(tr);
    });
}

/**
 * 游戏结束时，上传分数到数据库
 */
async function uploadScoreToDatabase(playerId, score, level) {
    const payload = {
        score: score,
        level: level
    };

    try {
        // 解除注释，向后端发送真实的 POST 请求
        const response = await fetch(`${API_BASE_URL}/save_score.php`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();
        if (result.success) {
            console.log("Score successfully saved to database!");
        } else {
            console.error("Database error:", result.message);
        }
    } catch (error) {
        console.error("Failed to upload score:", error);
    }
}


const debounce = (func, delay) => {
    let timeoutId;
    return (...args) => {
        clearTimeout(timeoutId);
        timeoutId = setTimeout(() => func.apply(null, args), delay);
    };
};


async function performSearch(searchQuery, searchType = 'user') {
    console.log(`[Search API] Searching for ${searchType}: "${searchQuery}"`);
    
    try {
        // 真正连接后端的搜索接口 search_api.php
        const response = await fetch(`${API_BASE_URL}/search_api.php?type=${searchType}&q=${encodeURIComponent(searchQuery)}`);
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const data = await response.json();
        
        if (data.success) {
            return data.results;
        } else {
            console.error("Backend error:", data.error);
            return [];
        }
        
    } catch (error) {
        console.error("Search failed:", error);
        return [];
    }
}

const handleSearchInput = debounce(async (event) => {
    const query = event.target.value.trim();
    
    // 只要搜索框不是空的，就允许搜索 (长度小于 1 才拦截)
    if (query.length < 1) {
        const resultsContainer = document.getElementById('searchResults');
        if (resultsContainer) {
            resultsContainer.innerHTML = '<p style="color: rgba(216, 209, 198, 0.5);">Start typing to see results...</p>';
        }
        return;
    }
    
    const searchType = document.getElementById('searchTypeSelect').value; 
    const results = await performSearch(query, searchType);
    
    renderSearchResults(results, searchType);
}, 400);

function renderSearchResults(results, type) {
    const resultsContainer = document.getElementById('searchResults');
    if (!resultsContainer) return;
    
    resultsContainer.innerHTML = ''; // 清空旧结果
    
    if (results.length === 0) {
        resultsContainer.innerHTML = '<p>No results found.</p>';
        return;
    }

    results.forEach(item => {
        const div = document.createElement('div');
        div.className = 'search-result-item';
        if (type === 'user') {
            div.innerHTML = `<strong>${item.player_name}</strong> - Joined: ${new Date(item.created_at).toLocaleDateString()}`;
        } else if (type === 'history') {
            div.innerHTML = `<strong>${item.player_name}</strong> played <strong>Level ${item.level_id}</strong> 
                             <br><span style="font-size: 0.9em; color: #019897;">Score: ${item.score} | Date: ${item.played_at}</span>`;
        }
        resultsContainer.appendChild(div);
    });
}