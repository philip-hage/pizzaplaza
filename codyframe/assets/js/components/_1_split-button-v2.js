// File#: _1_split-button-v2
// Usage: codyhouse.co/license
(function() {
	var SplitBtn = function(element) {
		this.element = element;
    this.itemsList = this.element.getElementsByClassName('js-split-btn-v2__list-wrapper');
		this.menuItems = this.element.getElementsByClassName('js-split-btn-v2__item');
		this.trigger = this.element.getElementsByClassName('js-split-btn-v2__btn');
    this.morphBg = this.element.getElementsByClassName('js-split-btn-v2__morph-bg');
		this.menuIsOpen = false;
    this.menuVisibleClass = 'split-btn-v2--expanded';
    if(this.trigger.length < 1 || this.morphBg.length < 1 || this.itemsList.length < 1) return;
		this.initSplitBtn();
		this.initSplitBtnEvents();
	};	

	SplitBtn.prototype.initSplitBtn = function() {
		// init aria-labels
		for(var i = 0; i < this.trigger.length; i++) {
      this.trigger[i].setAttribute('aria-expanded', 'false');
      this.trigger[i].setAttribute('aria-haspopup', 'true');
		}
		// init tabindex
		for(var i = 0; i < this.menuItems.length; i++) {
			this.menuItems[i].setAttribute('tabindex', '0');
		}
	};

	SplitBtn.prototype.initSplitBtnEvents = function() {
		var self = this;
		self.trigger[0].addEventListener('click', function(event){
      event.preventDefault();
      // toggle menu
      self.toggleMenu(!self.element.classList.contains(self.menuVisibleClass), true);
    });
		
		// keyboard events
		this.element.addEventListener('keydown', function(event) {
			// use up/down arrow to navigate list of menu items
			if( !event.target.classList.contains('js-split-btn-v2__item') ) return;
			if( (event.keyCode && event.keyCode == 40) || (event.key && event.key.toLowerCase() == 'arrowdown') ) {
				self.navigateItems(event, 'next');
			} else if( (event.keyCode && event.keyCode == 38) || (event.key && event.key.toLowerCase() == 'arrowup') ) {
				self.navigateItems(event, 'prev');
			}
		});
	};

	SplitBtn.prototype.toggleMenu = function(bool, moveFocus) {
		var self = this;
		// toggle menu visibility
    this.element.classList.toggle(this.menuVisibleClass, bool);
		this.menuIsOpen = bool;
    this.animateBg(bool);
		if(bool) {
			this.trigger[0].setAttribute('aria-expanded', 'true');
      this.menuItems[0].focus();
			this.menuItems[0].addEventListener("transitionend", function(event) {
        self.menuItems[0].focus();
      }, {once: true});
		} else if(this.trigger[0]) {
			this.trigger[0].setAttribute('aria-expanded', 'false');
			if(moveFocus) this.trigger[0].focus();
		}
	};

	SplitBtn.prototype.navigateItems = function(event, direction) {
		event.preventDefault();
		var index = Array.prototype.indexOf.call(this.menuItems, event.target),
			nextIndex = direction == 'next' ? index + 1 : index - 1;
		if(nextIndex < 0) nextIndex = this.menuItems.length - 1;
		if(nextIndex > this.menuItems.length - 1) nextIndex = 0;
    this.menuItems[nextIndex].focus();
	};

	SplitBtn.prototype.checkMenuFocus = function() {
		var menuParent = document.activeElement.closest('.js-split-btn-v2');
		if (!menuParent || !this.element.contains(menuParent)) this.toggleMenu(false, false);
	};

	SplitBtn.prototype.checkMenuClick = function(target) {
		if( !this.element.contains(target) && !target.closest('[aria-controls="'+this.elementId+'"]')) this.toggleMenu(false);
	};

  SplitBtn.prototype.animateBg = function(bool) {
    if(bool) {
      // expand bg
      var listInfo = this.itemsList[0].getBoundingClientRect(),
        bgInfo = this.morphBg[0].getBoundingClientRect();
      
      this.morphBg[0].style.transform = 'translateX('+(listInfo.left - bgInfo.left)+'px) translateY('+(listInfo.top - bgInfo.top)+'px) translateZ(-0.1px)';
      this.morphBg[0].style.height = listInfo.height+'px';
      this.morphBg[0].style.width = listInfo.width+'px';
    } else {
      // go back to initial state -> remove style
      this.morphBg[0].style = '';
    }
  };

	window.SplitBtn = SplitBtn;

	//initialize the SplitBtn objects
	var splitBtn = document.getElementsByClassName('js-split-btn-v2');
	if( splitBtn.length > 0 ) {
		var splitBtnArray = [];
		for( var i = 0; i < splitBtn.length; i++) {
			(function(i){
				splitBtnArray.push(new SplitBtn(splitBtn[i]));
			})(i);
		}

		// listen for key events
		window.addEventListener('keyup', function(event){
			if( event.key && event.key.toLowerCase() == 'tab' ) {
				//close menu if focus is outside menu element
				splitBtnArray.forEach(function(element){
					element.checkMenuFocus();
				});
			} else if( event.key && event.key.toLowerCase() == 'escape' ) {
				// close menu on 'Esc'
				splitBtnArray.forEach(function(element){
					element.toggleMenu(false, true);
				});
			} 
		});
		// close menu when clicking outside it
		window.addEventListener('click', function(event){
			splitBtnArray.forEach(function(element){
				element.checkMenuClick(event.target);
			});
		});
		// on resize -> close all menu elements
		window.addEventListener('resize', function(event){
			splitBtnArray.forEach(function(element){
				element.toggleMenu(false, false);
			});
		});
		// on scroll -> close all menu elements
		window.addEventListener('scroll', function(event){
			splitBtnArray.forEach(function(element){
				if(element.menuIsOpen) element.toggleMenu(false, false);
			});
		});
	}
}());