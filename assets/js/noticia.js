 // Sistema de autenticação
        let isLoggedIn = false;
        
        // Credenciais de exemplo (em produção, use um sistema seguro)
        const validCredentials = {
            username: 'adm',
            password: '@agrovila25luiz'
        };

        // Array para armazenar as notícias
        let news = [
            {
                id: 1,
                image: "https://horadecodar.com.br/wp-content/uploads/2023/03/programacao-no-dia-a-dia.jpg",
                title: "Agrovila são luiz vai ao ar",
                caption: "Neste dia 15 finalmente será possível acessar nosso site pela primeira vez",
                text: " Nosso objetivo é transformar a Cozinha Comunitária em um centro de produção e comercialização de alimentos, envolvendo 50 famílias de agricultores. Verificar o sucesso através da participação e desempenho nos cursos, funcionamento regular da cozinha e avaliações de satisfação e desempenho econômico social dos produtores.",
                date: "15 de Dezembro de 2025"
            },
            
        ];

        // Função para mostrar/ocultar elementos baseado no login
        function updateUIForAuth() {
            const loginSection = document.getElementById('loginSection');
            const loggedInSection = document.getElementById('loggedInSection');
            
            if (isLoggedIn) {
                loginSection.classList.add('hidden');
                loggedInSection.classList.remove('hidden');
            } else {
                loginSection.classList.remove('hidden');
                loggedInSection.classList.add('hidden');
            }
        }

        // Função para login
        function login(username, password) {
            if (username === validCredentials.username && password === validCredentials.password) {
                isLoggedIn = true;
                updateUIForAuth();
                renderNews();
                closeLoginModal();
                
                // Mostrar mensagem de sucesso
                showNotification('✅ Login realizado com sucesso!', 'success');
                return true;
            } else {
                showNotification('❌ Credenciais inválidas!', 'error');
                return false;
            }
        }

        // Função para logout
        function logout() {
            if (confirm('Tem certeza que deseja sair?')) {
                isLoggedIn = false;
                updateUIForAuth();
                renderNews();
                showNotification('👋 Logout realizado com sucesso!', 'info');
            }
        }

        // Função para mostrar notificações
        function showNotification(message, type) {
            // Remove notificação existente se houver
            const existingNotification = document.querySelector('.notification');
            if (existingNotification) {
                existingNotification.remove();
            }

            const notification = document.createElement('div');
            notification.className = `notification ${type}`;
            notification.innerHTML = message;
            
            // Estilos da notificação
            notification.style.cssText = `
                position: fixed;
                top: 120px;
                right: 2rem;
                padding: 1rem 2rem;
                border-radius: 10px;
                font-weight: bold;
                z-index: 3000;
                animation: slideIn 0.3s ease;
                max-width: 300px;
                box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            `;

            // Cores baseadas no tipo
            const colors = {
                success: 'background: linear-gradient(45deg, #4CAF50, #45a049); color: white;',
                error: 'background: linear-gradient(45deg, #e74c3c, #c0392b); color: white;',
                info: 'background: linear-gradient(45deg, #3498db, #2980b9); color: white;'
            };
            
            notification.style.cssText += colors[type];

            document.body.appendChild(notification);

            // Remove após 3 segundos
            setTimeout(() => {
                notification.style.animation = 'slideOut 0.3s ease';
                setTimeout(() => notification.remove(), 300);
            }, 3000);
        }

        // Adicionar CSS para animações das notificações
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideIn {
                from { transform: translateX(100%); opacity: 0; }
                to { transform: translateX(0); opacity: 1; }
            }
            @keyframes slideOut {
                from { transform: translateX(0); opacity: 1; }
                to { transform: translateX(100%); opacity: 0; }
            }
        `;
        document.head.appendChild(style);

        // Função para renderizar as notícias
        function openLoginModal() {
            document.getElementById('loginModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Função para fechar modal de login
        function closeLoginModal() {
            document.getElementById('loginModal').style.display = 'none';
            document.body.style.overflow = 'auto';
            document.getElementById('loginForm').reset();
            document.getElementById('loginError').style.display = 'none';
        }

        // Função para mostrar mensagem de login necessário
        function showLoginMessage() {
            showNotification('🔐 Faça login para adicionar notícias!', 'info');
            setTimeout(() => openLoginModal(), 1000);
        }
        function renderNews() {
            const container = document.getElementById('newsContainer');
            
            if (news.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <h2>🌾 Nenhuma notícia encontrada</h2>
                        <p>Seja o primeiro a adicionar uma notícia ao AgroNews!</p>
                        <button class="add-news-btn" onclick="showLoginMessage()">+ Adicionar Primeira Notícia</button>
                    </div>
                `;
                return;
            }

            container.innerHTML = news.map(item => `
                <article class="news-item">
                    ${isLoggedIn ? `<button class="delete-btn" onclick="deleteNews(${item.id})" title="Excluir notícia">×</button>` : ''}
                    <img src="${item.image}" alt="${item.title}" class="news-image" onerror="this.src='https://images.unsplash.com/photo-1500937386664-56d1dfef3854?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80'">
                    <div class="news-content">
                        <h1 class="news-title">${item.title}</h1>
                        <p class="news-caption">${item.caption}</p>
                        <div class="news-text">${item.text}</div>
                        <div class="news-date">📅 ${item.date}</div>
                    </div>
                </article>
            `).join('');
        }

        // Função para abrir o modal de notícias (apenas para usuários logados)
        function openModal() {
            if (!isLoggedIn) {
                showLoginMessage();
                return;
            }
            document.getElementById('newsModal').style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Função para fechar o modal
        function closeModal() {
            document.getElementById('newsModal').style.display = 'none';
            document.body.style.overflow = 'auto'; // Restaura scroll do body
            document.getElementById('newsForm').reset();
        }

        // Função para adicionar nova notícia
        function addNews(image, title, caption, text) {
            const newNews = {
                id: Date.now(), // ID único baseado no timestamp
                image: image,
                title: title,
                caption: caption,
                text: text,
                date: new Date().toLocaleDateString('pt-BR', {
                    day: 'numeric',
                    month: 'long',
                    year: 'numeric'
                })
            };
            
            news.unshift(newNews); // Adiciona no início do array
            renderNews();
        }

        // Função para deletar notícia (apenas para usuários logados)
        function deleteNews(id) {
            if (!isLoggedIn) {
                showNotification('🔐 Faça login para gerenciar notícias!', 'error');
                return;
            }
            if (confirm('Tem certeza que deseja excluir esta notícia?')) {
                news = news.filter(item => item.id !== id);
                renderNews();
                showNotification('🗑️ Notícia excluída com sucesso!', 'info');
            }
        }

        // Event listener para o formulário de login
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            const loginSuccess = login(username, password);
            
            if (!loginSuccess) {
                const errorDiv = document.getElementById('loginError');
                errorDiv.textContent = '❌ Usuário ou senha incorretos!';
                errorDiv.style.display = 'block';
                
                // Limpa o erro após 3 segundos
                setTimeout(() => {
                    errorDiv.style.display = 'none';
                }, 3000);
            }
        });

        // Event listener para o formulário de notícias
        document.getElementById('newsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const image = document.getElementById('newsImage').value;
            const title = document.getElementById('newsTitle').value;
            const caption = document.getElementById('newsCaption').value;
            const text = document.getElementById('newsText').value;
            
            addNews(image, title, caption, text);
            closeModal();
            showNotification('✨ Notícia adicionada com sucesso!', 'success');
            
            // Scroll suave para a nova notícia
            setTimeout(() => {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }, 100);
        });

        // Fechar modal ao clicar fora dele
        window.addEventListener('click', function(event) {
            const newsModal = document.getElementById('newsModal');
            const loginModal = document.getElementById('loginModal');
            
            if (event.target === newsModal) {
                closeModal();
            }
            if (event.target === loginModal) {
                closeLoginModal();
            }
        });

        // Fechar modal com ESC
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
                closeLoginModal();
            }
        });

        // Inicializar a página
        updateUIForAuth();
        renderNews();