/**
 * NBA Predictor - Main JavaScript file
 * Handles interactive features and UI components
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // Initialize tooltips
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    tooltipTriggerList.forEach(function(tooltipTriggerEl) {
        new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Initialize popovers
    const popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'));
    popoverTriggerList.forEach(function(popoverTriggerEl) {
        new bootstrap.Popover(popoverTriggerEl);
    });

    // Team comparison form handling
    const teamComparisonForm = document.getElementById('teamComparisonForm');
    if (teamComparisonForm) {
        teamComparisonForm.addEventListener('submit', function(e) {
            const team1 = document.getElementById('team1').value;
            const team2 = document.getElementById('team2').value;
            
            if (team1 === team2) {
                e.preventDefault();
                alert('Veuillez sélectionner deux équipes différentes pour la comparaison.');
            }
        });
    }

    // Team selector interactions
    const teamSelectors = document.querySelectorAll('.team-selector');
    teamSelectors.forEach(function(selector) {
        selector.addEventListener('change', function() {
            const selectedTeam = this.value;
            const teamLogoContainer = this.closest('.team-selection-container').querySelector('.team-logo-container');
            
            if (selectedTeam && teamLogoContainer) {
                const logoPath = `/images/teams/${selectedTeam.toLowerCase()}.png`;
                teamLogoContainer.innerHTML = `<img src="${logoPath}" alt="${selectedTeam}" class="img-fluid team-logo" style="max-height: 100px;">`;
            } else if (teamLogoContainer) {
                teamLogoContainer.innerHTML = '<div class="text-center text-muted">Sélectionnez une équipe</div>';
            }
        });
    });

    // Handle player search autocomplete
    const playerSearchInput = document.getElementById('playerSearch');
    if (playerSearchInput) {
        playerSearchInput.addEventListener('input', debounce(function(e) {
            const searchTerm = e.target.value;
            if (searchTerm.length < 3) return;
            
            fetch(`/api/players/search?term=${encodeURIComponent(searchTerm)}`)
                .then(response => response.json())
                .then(data => {
                    const resultsContainer = document.getElementById('searchResults');
                    resultsContainer.innerHTML = '';
                    
                    if (data.length === 0) {
                        resultsContainer.innerHTML = '<div class="p-2 text-muted">Aucun résultat</div>';
                        return;
                    }
                    
                    data.forEach(player => {
                        const playerItem = document.createElement('div');
                        playerItem.className = 'search-result-item p-2 border-bottom';
                        playerItem.innerHTML = `
                            <div class="d-flex align-items-center">
                                <img src="/images/players/${player.id_joueur}.jpg" 
                                     alt="${player.nom_joueur}" 
                                     class="rounded-circle me-2" 
                                     width="30" height="30"
                                     onerror="this.src='/images/player-placeholder.jpg'">
                                <div>
                                    <div>${player.nom_joueur}</div>
                                    <small class="text-muted">${player.abr_equipe} | ${player.position}</small>
                                </div>
                            </div>
                        `;
                        playerItem.addEventListener('click', function() {
                            window.location.href = `/players/view/${player.id_joueur}`;
                        });
                        resultsContainer.appendChild(playerItem);
                    });
                    
                    resultsContainer.style.display = 'block';
                })
                .catch(error => console.error('Error fetching player data:', error));
        }, 300));
        
        // Hide search results when clicking outside
        document.addEventListener('click', function(e) {
            const resultsContainer = document.getElementById('searchResults');
            if (resultsContainer && !playerSearchInput.contains(e.target) && !resultsContainer.contains(e.target)) {
                resultsContainer.style.display = 'none';
            }
        });
    }

    // Initialize charts if they exist on the page
    initializeCharts();
    
    // Handle follow/unfollow actions
    setupFollowActions();
    
    // Prediction confidence visualization
    updatePredictionBars();
    
    // Handle match filtering
    setupMatchFiltering();
});

/**
 * Debounce function to limit how often a function can be called
 */
function debounce(func, delay) {
    let debounceTimer;
    return function() {
        const context = this;
        const args = arguments;
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => func.apply(context, args), delay);
    };
}

/**
 * Initialize Chart.js charts
 */
function initializeCharts() {
    // Player Stats Chart
    const playerStatsChart = document.getElementById('playerStatsChart');
    if (playerStatsChart) {
        const ctx = playerStatsChart.getContext('2d');
        const data = JSON.parse(playerStatsChart.dataset.stats);
        
        new Chart(ctx, {
            type: 'radar',
            data: {
                labels: ['Points', 'Rebonds', 'Passes', 'Interceptions', 'Contres', 'Efficacité'],
                datasets: [{
                    label: data.player_name,
                    data: [
                        data.points, 
                        data.rebounds, 
                        data.assists, 
                        data.steals, 
                        data.blocks, 
                        data.efficiency
                    ],
                    backgroundColor: 'rgba(26, 118, 210, 0.2)',
                    borderColor: '#1a76d2',
                    borderWidth: 2,
                    pointBackgroundColor: '#1a76d2'
                }]
            },
            options: {
                scales: {
                    r: {
                        beginAtZero: true,
                        max: 100
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return `${context.dataset.label}: ${context.raw}%`;
                            }
                        }
                    }
                }
            }
        });
    }
    
    // Team Performance Chart
    const teamPerformanceChart = document.getElementById('teamPerformanceChart');
    if (teamPerformanceChart) {
        const ctx = teamPerformanceChart.getContext('2d');
        const data = JSON.parse(teamPerformanceChart.dataset.performance);
        
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: data.labels,
                datasets: [{
                    label: 'Victoires',
                    data: data.wins,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.1,
                    fill: true
                }, {
                    label: 'Défaites',
                    data: data.losses,
                    borderColor: '#dc3545',
                    backgroundColor: 'rgba(220, 53, 69, 0.1)',
                    tension: 0.1,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Nombre'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Match'
                        }
                    }
                }
            }
        });
    }
    
    // Prediction Accuracy Chart
    const predictionAccuracyChart = document.getElementById('predictionAccuracyChart');
    if (predictionAccuracyChart) {
        const ctx = predictionAccuracyChart.getContext('2d');
        const data = JSON.parse(predictionAccuracyChart.dataset.accuracy);
        
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Prédictions Correctes', 'Prédictions Incorrectes'],
                datasets: [{
                    data: [data.accurate, data.inaccurate],
                    backgroundColor: ['#28a745', '#dc3545'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${percentage}% (${value} prédictions)`;
                            }
                        }
                    }
                }
            }
        });
    }
}

/**
 * Setup follow/unfollow functionality for teams and players
 */
function setupFollowActions() {
    document.querySelectorAll('.follow-btn, .unfollow-btn').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const url = this.getAttribute('href');
            const isFollowing = this.classList.contains('unfollow-btn');
            const entityType = url.includes('/teams/') ? 'team' : 'player';
            
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Toggle button state
                    if (isFollowing) {
                        this.innerHTML = `<i class="far fa-star"></i> Suivre ${entityType === 'team' ? 'cette équipe' : 'ce joueur'}`;
                        this.classList.remove('btn-danger', 'unfollow-btn');
                        this.classList.add('btn-outline-primary', 'follow-btn');
                    } else {
                        this.innerHTML = `<i class="fas fa-star"></i> Ne plus suivre`;
                        this.classList.remove('btn-outline-primary', 'follow-btn');
                        this.classList.add('btn-danger', 'unfollow-btn');
                    }
                    
                    // Show feedback message
                    const messageContainer = document.createElement('div');
                    messageContainer.className = 'alert alert-success alert-dismissible fade show mt-3';
                    messageContainer.innerHTML = `
                        ${data.message}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    `;
                    
                    const container = this.closest('.card-body');
                    container.appendChild(messageContainer);
                    
                    // Auto-dismiss after 3 seconds
                    setTimeout(() => {
                        messageContainer.remove();
                    }, 3000);
                }
            })
            .catch(error => console.error('Error updating follow status:', error));
        });
    });
}

/**
 * Update the prediction bars to show the predicted win percentages visually
 */
function updatePredictionBars() {
    document.querySelectorAll('.prediction-bar').forEach(bar => {
        const homePercentage = parseFloat(bar.dataset.homePercentage) || 50;
        const homeBar = bar.querySelector('.team-home');
        const awayBar = bar.querySelector('.team-away');
        
        if (homeBar && awayBar) {
            homeBar.style.width = `${homePercentage}%`;
            awayBar.style.width = `${100 - homePercentage}%`;
            
            // Add percentage text if bar is wide enough
            if (homePercentage > 15) {
                homeBar.textContent = `${Math.round(homePercentage)}%`;
            } else {
                homeBar.textContent = '';
            }
            
            if (100 - homePercentage > 15) {
                awayBar.textContent = `${Math.round(100 - homePercentage)}%`;
            } else {
                awayBar.textContent = '';
            }
        }
    });
}

/**
 * Setup match filtering functionality
 */
function setupMatchFiltering() {
    const matchFilterForm = document.getElementById('matchFilterForm');
    if (matchFilterForm) {
        // Team filtering
        const teamFilter = document.getElementById('teamFilter');
        if (teamFilter) {
            teamFilter.addEventListener('change', function() {
                matchFilterForm.submit();
            });
        }
        
        // Date range filtering
        const dateRangeFilter = document.getElementById('dateRangeFilter');
        if (dateRangeFilter) {
            dateRangeFilter.addEventListener('change', function() {
                matchFilterForm.submit();
            });
        }
    }
}
