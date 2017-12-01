<div class='paginacion'>
    <ul>
        <?php if (isset($this->_paginacion)): ?>

            <?php if ($this->_paginacion['primero']): ?>
                <a href='<?php echo $link . $this->_paginacion['primero']; ?>'>
                    <li title='Primero'>
                        <i class='fa fa-step-backward'></i>
                    </li>
                </a>
            <?php else: ?>
                <li class='disabled'><i class='fa fa-step-backward'></i></li>
            <?php endif; ?>

            <?php if ($this->_paginacion['anterior']): ?>
                <a href='<?php echo $link . $this->_paginacion['anterior']; ?>'>
                    <li title='Anterior'>
                        <i class='fa fa-backward'></i>
                    </li>
                </a>
            <?php else: ?>
                <li class='disabled'><i class='fa fa-backward'></i></li>
            <?php endif; ?>

            <?php for ($i = 0; $i < count($this->_paginacion['rango']); $i++): ?>
                <?php if ($this->_paginacion['actual'] == $this->_paginacion['rango'][$i]): ?>
                    <li class='active'><?php echo $this->_paginacion['rango'][$i]; ?></li>
                <?php else: ?>
                    <a href='<?php echo $link . $this->_paginacion['rango'][$i]; ?>'>
                        <li>
                            <?php echo $this->_paginacion['rango'][$i]; ?>
                        </li>
                    </a>
                <?php endif; ?>
            <?php endfor; ?>

            <?php if ($this->_paginacion['siguiente']): ?>
                <a href='<?php echo $link . $this->_paginacion['siguiente']; ?>'>
                    <li title='Siguiente'>
                        <i class='fa fa-forward'></i>
                    </li>
                </a>
            <?php else: ?>
                <li class='disabled'><i class='fa fa-forward'></i></li>
            <?php endif; ?>

            <?php if ($this->_paginacion['ultimo']): ?>
                <a href='<?php echo $link . $this->_paginacion['ultimo']; ?>'>
                    <li title='&Uacute;ltimo'>
                        <i class='fa fa-step-forward'></i>
                    </li>
                </a>
            <?php else: ?>
                <li class='disabled'><i class='fa fa-step-forward'></i></li>
                <?php endif; ?>

        <?php endif; ?>
    </ul>
</div>