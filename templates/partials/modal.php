<style>
    /* MODAL WINDOW */
    .cerv-modal-overlay{
        position: fixed;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, .5);
        width: 100%;
        height: 100%;
        z-index: 100;
        display:none;
    }

    .cerv-modal-overlay:hover{
        cursor: pointer;
    }

    .cerv-modal{
        position: relative;
        top: 100px;
        width: 600px;
        max-width: 95%;
        min-height: 400px;
        margin: 0 auto;
        border: 1px solid #ddd;
        background: #fff;
        border-radius: 5px;
    }

    .cerv-modal{
        cursor: default;
    }

    .cerv-modal h5,
    .cerv-modal p{
        margin: 0;
    }

    .cerv-modal h5{
        margin-top: 12px;
        margin-bottom: 12px;
        font-size: 1em;
    }
    
    .cerv-modal p{
        margin-bottom: 8px;
        font-size: .8em;
    }

    .cerv-modal hr{
        margin: 1em 0;
    }

    .cerv-modal-header{        
        border-bottom: 1px solid #ddd;
        position:relative;
    }

    .cerv-modal-header h4{        
        margin: 0;
        padding: .5em;
        text-align: center;
    }

    .cerv-modal-content{
        padding: .5em 1em;
    }

    .close-cerv-modal-btn{
        position: absolute;
        top: 0;
        right: 0;
        height: 100%;
        width: 60px;
        padding-top: 17px;
        text-align: center;
        font-size: 1.5em;
    }

    .close-cerv-modal-btn:hover{
        cursor: pointer;
    }
</style>

<div class="cerv-modal-overlay">
    <div class="cerv-modal">
        <div class="cerv-modal-header">
            <h4 class="name">Leanne Graham</h4>
            <span class="close-cerv-modal-btn">&times;</span>
        </div>
        <div class="cerv-modal-content">
            <div class="user-info">
                <h5>User Info</h5>
                <p><span class="modal-label">Username: </span> Bret</p>
                <p><span class="modal-label">Email: </span> Sincere@april.biz</p>
                <p><span class="modal-label">Phone: </span> 1-770-736-8031 x56442</p>
                <p><span class="modal-label">Website: </span> hildegard.org</p>
                <p><span class="modal-label">Address: </span> Apt. 556, Kulas Light, Gwenborough, 92998-3874</p>
            </div>
            <hr />
            <div class="company">
                <h5>Company</h5>
                <p><span class="modal-label">Name: </span>Romaguera-Crona</p>
                <p><span class="modal-label">Catch Phrase: </span>Multi-layered client-server neural-net</p>
                <p><span class="modal-label">BS: </span>harness real-time e-markets</p>
            </div>  
        </div>
    </div>
</div>

