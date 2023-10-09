#   T r a v a i l l e r   s u r   l e   p r o j e t   e n   l o c a l 
 
     -   # # #   I n s t a l l e r   e t   c o n f i g u r e r   M A M P 
         -   I n s t a l l e z   [ M A M P ] ( h t t p s : / / w w w . m a m p . i n f o / e n / d o w n l o a d s )   �   l ' e m p l a c e m e n t   p a r   d � f a u t   e t   e n   d � c o c h a n t   l ' i n s t a l l a t i o n   d e s   p r o g r a m m e s   a d d i t i o n n e l s   _ M A M P   P R O _   e t   _ A p a c h e   B o n j o u r _ . 
         -   S p � c i f i e z   l a   v e r s i o n   8 . 1 . 0   d a n s   _ M A M P   >   P r � f � r e n c e s   >   P H P _   e t   r e d � m a r r e z   l e   s e r v e u r . 
         -   A c t i v e z   l ' a f f i c h a g e   d e s   e r r e u r s   P H P   e n   i n d i q u a n t   ` d i s p l a y _ e r r o r s   =   o n `   d a n s   < a   h r e f = " C : \ M A M P \ c o n f \ p h p 8 . 1 . 0 \ p h p . i n i " > p h p . i n i < / a >   �   l a   l i g n e   ` 3 7 4 ` . 
         -   G l i s s e z   l e   p r o j e t   d a n s   < a   h r e f = " C : \ M A M P \ h t d o c s " > h t d o c s < / a > . 
         >       M A M P   p e r m e t   d e   f a c i l e m e n t   m e t t r e   e n   p l a c e   u n   s e r v e u r   P H P   A p a c h e   e t   M y S Q L   s o u s   l ' i n t e r f a c e   p h p M y A d m i n . 
     
     -   # # #   I n s � r e r   l e s   t a b l e s   d a n s   l a   b a s e   d e   d o n n � e s 
         -   O u v r e z   < a   h r e f = " h t t p : / / l o c a l h o s t / S t a g e o / a s s e t s / p h p / d a t a b a s e . p h p " > d a t a b a s e . p h p < / a >   e t   c o l l e z   l e   t e x t e   d a n s   < a   h r e f = " h t t p : / / l o c a l h o s t / p h p M y A d m i n / i n d e x . p h p ? r o u t e = / s e r v e r / s q l " > p h p M y A d m i n   >   S Q L < / a > 
 
     -   # # #   I n s t a l l e r   l e s   d � p e n d a n c e s 
         -   I n s t a l l e z   [ C o m p o s e r ] ( h t t p : / / g e t c o m p o s e r . o r g / d o w n l o a d )   s a n s   c o c h e r   l e   m o d e   d � v e l o p p e u r ,   e t   e n   s p � c i f i a n t   
             l ' � x e c u t a b l e   P H P   8 . 1 . 0   d e   M A M P   
             ` C : \ M A M P \ b i n \ p h p \ p h p 8 . 1 . 0 \ p h p . e x e ` . 
         -   D � p l a c e z   v o t r e   < a   h r e f = " C : \ M A M P \ c o n f \ p h p 8 . 1 . 0 \ p h p . i n i " > p h p . i n i < / a >   d e p u i s   < a   h r e f = " C : \ M A M P \ c o n f \ p h p 8 . 1 . 0 " > c o n f \ p h p 8 . 1 . 0 < / a >   d a n s   < a   h r e f = " C : \ M A M P \ b i n \ p h p \ p h p 8 . 1 . 0 " > b i n \ p h p \ p h p 8 . 1 . 0 < / a > . 
         -   R a j o u t e z   u n e   v a r i a b l e   d ' e n v i r o n n e m e n t   ` C : \ M A M P \ b i n \ p h p \ p h p 8 . 1 . 0 `   d a n s   _ V a r i a b l e s   d ' e n v i r o n n e m e n t   >   P a t h   >   N e w _ . 
         -   � x e c u t e z   l e s   c o m m a n d e s   s u i v a n t e s   p o u r   i n s t a l l e r   l e s   d � p e n d a n c e s   s p � c i f i � e s   d a n s   [ c o m p o s e r . j s o n ] ( c o m p o s e r . j s o n ) . 
         ` ` ` b a s h 
         c o m p o s e r   c o n f i g   - g   - -   d i s a b l e - t l s   f a l s e   
         ` ` ` 
         ` ` ` b a s h 
         c o m p o s e r   i n s t a l l 
         ` ` ` 
         >   C o m p o s e r   e s t   u t i l i s �   d a n s   l e   c a d r e   d u   d � v e l o p p e m e n t   d  a p p l i c a t i o n s   P H P   p o u r   g � r e r   d e s   d � p e n d a n c e s .   L e s   f i c h i e r s   d e s   d � p e n d a n c e s   s e   t r o u v e r o n t   d a n s   u n   d o s s i e r   [ v e n d o r ] ( v e n d o r )   q u i   e s t   s p � c i f i �   d a n s   [ . g i t i g n o r e ] ( . g i t i g n o r e )   e n   r a i s o n   d e   s a   t a i l l e . 
     
 A c c � d e z   a u   s i t e   a p r � s   a v o i r   l a n c �   l e   s e r v e u r   M A M P   d e p u i s   c e   [ l i e n ] ( h t t p : / / l o c a l h o s t / S t a g e o ) 
 
 #   T r a v a i l l e r   s u r   l e   p r o j e t   �   d i s t a n c e 
 
     -   # # #   I n s t a l l e r   e t   u t i l i s e r   F i l e Z i l l a 
         -   I n s t a l l e z   [ F i l e Z i l l a ] ( h t t p s : / / f i l e z i l l a - p r o j e c t . o r g / d o w n l o a d . p h p ) 
         -   A j o u t e z   u n e   n o u v e l l e   c o n n e x i o n   d e p u i s   _ F i l e   >   S i t e   M a n a g e r   >   N e w   s i t e _ .   R e m p l i s s e z   l e   f o r m u l a i r e   a v e c   l e s   i n f o r m a t i o n s   s u i v a n t e s : 
             -   * * P r o t o c o l : * *   ` S F T P   -   S S H   F i l e   T r a n s f e r   P r o t o c o l ` 
             -   * * H o s t : * *   ` f t p i n f o . i u t m o n t p . u n i v - m o n t p 2 . f r ` 
             -   * * L o g o n   T y p e : * *   ` A s k   f o r   p a s s w o r d ` 
             -   * * U s e r : * *   ` r i o s q ` 
             -   * * P a s s w o r d : * *   ` 0 4 0 9 2 0 2 3 ` 
     
         A c c � d e z   a u   s i t e   a p r � s   a v o i r   l a n c �   l e   s e r v e u r   M A M P   d e p u i s   c e   [ l i e n ] ( h t t p s : / / w e b i n f o . i u t m o n t p . u n i v - m o n t p 2 . f r / ~ r i o s q / S t a g e o ) .   D o u b l e - c l i q u e z   s u r   l e s   f i c h i e r s   �   t r a n s f � r e r   s u r   l e   d � p � t   �   d i s t a n c e .   P o u r   p l u s   f a c i l e m e n t   
         n a v i g u e r ,   v o u s   p o u v e z   a c t i v e r   l ' o p t i o n   _ V i e w   >   S y n c h r o n i z e d   b r o w s i n g _   e n   v o u s   m e t t a n t   a u   m � m e   r � p e r t o i r e   d e s   2   c � t � s . 
         >   F i l e Z i l l a   e s t   u n   p r o g r a m m e   q u i   p e r m e t   d e   g � r e r   d e s   d � p � t s   s o u s   f o r m e   d ' u n   e x p l o r a t e u r   d e   f i c h i e r   e n   s e   c o n n e c t a n t   e n   F T P   �   d e s   c l i e n t s . 
 
 #   M o d i f i e r   l e   s t y l e   d u   p r o j e t 
 
 >   N o u s   u t i l i s o n s   i c i   N o d e . j s   p o u r   g � r e r   d e s   d � p e n d a n c e s   J a v a S c r i p t   q u i   o f f r e n t   p l u s   d e   f o n c t i o n n a l i t � s   n o t a m m e n t   s u r   l e s   f i c h i e r   C S S . 
 -   I n s t a l l e z   [ N o d e . j s ] ( h t t p : / / n o d e j s . o r g / e n / d o w n l o a d ) . 
 -   E x e c u t e z   l a   c o m m a n d e   s u i v a n t e   p o u r   i n s t a l l e r   l e s   d � p e n d a n c e s   s p � c i f i � e s   d a n s   [ p a c k a g e . j s o n ] ( p a c k a g e . j s o n ) . 
 ` ` ` b a s h 
 n p m   i n s t a l l 
 ` ` ` 
 -   I n s t a l l e z   l e   p l u g i n   [ T a i l w i n d   C S S ] ( h t t p s : / / t a i l w i n d c s s . c o m / d o c s / i n s t a l l a t i o n )   d e p u i s   _ P a r a m � t r e s   >   P l u g i n s _   p o u r   b � n � n i f i c i e r   d e s   s u g g e s t i o n s   d e   c o m p l � t i o n s . * 
 -   E x e c u t e r   l a   c o m m a n d e   s u i v a n t e   �   c h a q u e   r e d � m a r r a g e   d e   l ' I D E   p o u r   a c t i v e r   l ' a u t o - c o m p i l a t i o n   d u   f i c h i e r   [ m a i n . p c s s ] ( a s s e t s / c s s / m a i n . p c s s )   e n   [ m a i n . c s s ] ( a s s e t s / c s s / m a i n . c s s ) . 
 ` ` ` b a s h 
 n p x   p o s t c s s   a s s e t s / c s s / m a i n . p c s s   - o   a s s e t s / c s s / m a i n . c s s   - w 
 ` ` ` 
 
 #   A j o u t e r   u n e   f o n c t i o n   d a n s   l e   p r o j e t 
 
 -   I n d i q u e z   l e   n o m   d e   l a   r o u t e   d a n s   [ R o u t e N a m e ] ( s r c \ L i b \ e n u m s \ R o u t e N a m e . p h p )   a f i n   d e   b � n � f i c i e r   d e   l ' a u t o - c o m p l � t i o n . 
 ` ` ` p h p 
 c a s e   S I G N _ I N _ F O R M   =   " s i g n I n F o r m " ; 
 c a s e   S I G N _ I N   =   " s i g n I n " ; 
 ` ` ` 
 -   A j o u t e r   l e s   i n f o r m a t i o n s   d e   r o u t e   d a n s   l e   t a b l e a u   ` $ r o u t e s `   d e   l a   f o n c t i o n   g e t R o u t e s C o l l e c t i o n   d a n s   [ R o u t e r ] ( s r c \ L i b \ R o u t e r . p h p ) . 
     -   * * p a t h : * *   C h e m i n   v e r s   l ' a c t i o n .   M e t t e z   l e s   a r g u m e n t s   e n t r e   a c c o l a d e s ,   r a j o u t e z   u n   ` ? `   s i   l ' a r g u m e n t   e s t   o p t i o n n e l . 
     -   * * d e f a u l t s : * *   F o n c t i o n   d u   c o n t r o l l e r   �   a p p e l e r   a u   f o r m a t   _ [ c a l l a b l e ] ( h t t p s : / / w w w . p h p . n e t / m a n u a l / f r / l a n g u a g e . t y p e s . c a l l a b l e . p h p ) _ . 
     -   * * m e t h o d s : * *   M � t h o d e   ` G E T `   o u   ` P O S T `   d a n s   l e   c a s   o �   2   r o u t e s   s e   p a r t a g e   l e   m � m e   c h e m i n   ( o p t i o n n e l ) . 
 ` ` ` p h p 
 [ 
     " n a m e "   = >   R o u t e N a m e : : S I G N _ I N _ F O R M , 
     " r o u t e "   = >   n e w   R o u t e ( 
         p a t h :   " / s i g n - i n / { e m a i l ? } " , 
         d e f a u l t s :   [ " _ c o n t r o l l e r "   = >   [ U s e r C o n t r o l l e r : : c l a s s ,   " s i g n I n " ] ] , 
         m e t h o d s :   " G E T " 
     ) 
 ] , 
 [ 
     " n a m e "   = >   R o u t e N a m e : : S I G N _ I N , 
     " r o u t e "   = >   n e w   R o u t e ( 
         p a t h :   " / s i g n - i n / { t o k e n } " , 
         d e f a u l t s :   [ " _ c o n t r o l l e r "   = >   [ U s e r C o n t r o l l e r : : c l a s s ,   " s i g n I n F o r m " ] ] , 
         m e t h o d s :   " P O S T " 
     ) 
 ] 
 ` ` ` 
 
 -   A j o u t e z   u n e   f o n c t i o n   d a n s   l e   [ c o n t r o l l e r ] ( s r c / C o n t r o l l e r )   c o r r e s p o n d a n t   e n   p a s s a n t   e n   p a r a m � t r e s   v a r i a b l e s   a v e c   l e s q u e l l e s   l ' a c t i o n   d u   c o n t r o l l e r   e s t   a p p e l �   ( v o i r   ` p a t h `   d e   l a   r o u t e   c o r r e s p o n d a n t e ) .   U n   a c t i o n   d ' u n   c o n t r o l l e r   d o i t   t o u j o u r s   r e t o u r n e r   u n   [ C o n t r o l l e r R e s p o n s e ] ( s r c / C o n t r o l l e r / C o n t r o l l e r R e s p o n s e . p h p )   d e m a n d a n t   l e s   p a r a m � t r e s   s u i v a n t s ,   1   s e u l   d e s   2   p r e m i e r s   d o i t   � t r e   s p � c i f i � : 
     -   * * t e m p l a t e : * *   C h e m i n   v e r s   u n e   v u e   T w i g   �   a f f i c h e r . 
     -   * * r e d i r e c t i o n : * *   U n   [ R o u t e N a m e ] ( s r c \ L i b \ e n u m s \ R o u t e N a m e . p h p )   s i   l a   f o n c t i o n   d o i t   p l u t � t   r e d i r i g e r   v e r s   u n e   a u t r e   r o u t e . 
     -   * * s t a t u s C o d e : * *   U n   [ S t a t u s C o d e ] ( s r c \ L i b \ e n u m s \ S t a t u s C o d e . p h p )   a d a p t �   �   r e n v o y e r   a u   c l i e n t   ( p a r   d � f a u t   ` S t a t u s C o d e : : O K ` ) . 
     -   * * p a r a m s : * *   U n   t a b l e a u   a s s o c i a t i f   d e   p a r a m � t r e s   o p t i o n n e l s   q u i   s e r o n t   p a s s �   �   l a   v u e   T w i g ,   o u   d a n s   l ' U R L   d e   l a   r o u t e   r e d i r i g � e . 
 ` ` ` p h p 
 p u b l i c   f u n c t i o n   s i g n I n F o r m ( s t r i n g   $ e m a i l   =   n u l l ) :   C o n t r o l l e r R e s p o n s e 
 { 
         U s e r C o n n e c t i o n : : s i g n O u t ( ) ; 
         / / a f f i c h e   l a   v u e   s i g n - i n . h t m l . t w i g   e t   l u i   p a s s e   d e s   v a r i a b l e s 
         r e t u r n   n e w   C o n t r o l l e r R e s p o n s e ( 
                 t e m p l a t e :   " u s e r / s i g n - i n . h t m l . t w i g " , 
                 p a r a m s :   [ 
                         " t o k e n "   = >   T o k e n : : g e n e r a t e T o k e n ( R o u t e N a m e : : I D E N T I F I E R _ S I G N _ I N _ F O R M ) ] , 
                         " e m a i l "   = >   $ e m a i l 
                 ] 
         ) ; 
 } 
 
 p u b l i c   f u n c t i o n   s i g n I n ( s t r i n g   $ t o k e n ) :   C o n t r o l l e r R e s p o n s e 
 { 
         i f   ( ! T o k e n : : v e r i f y ( $ t o k e n ) )   t h r o w   n e w   I n v a l i d T o k e n E x c e p t i o n ( ) ; 
         $ u s e r   =   $ t h i s - > r e p o s i t o r y - > g e t B y E m a i l ( $ _ P O S T [ " e m a i l " ] ) ; 
         i f   ( P a s s w o r d : : v e r i f y ( $ _ P O S T [ " p a s s w o r d " ] ,   $ u s e r - > g e t H a s h e d P a s s w o r d ( ) ) 
                 / / r e d i r i g e   e n   a r r i � r e   a v e c   u n   m e s s a g e   f l a s h   e t   p a s s e   $ e m a i l   e n   p a r a m � t r e 
                 t h r o w   n e w   S e r v i c e E x c e p t i o n ( 
                         m e s s a g e :   " L ' a d r e s s e   m a i l   o u   l e   m o t   d e   p a s s e   e s t   i n c o r r e c t . " , 
                         r e d i r e c t i o n :   R o u t e N a m e : : S I G N _ I N _ F O R M , 
                         p a r a m s :   [ " e m a i l "   = >   $ e m a i l ] 
                 ) ; 
                 
         U s e r C o n n e c t i o n : : s i g n I n ( $ u s e r ) ; 
         / / r e d i r i g e   v e r s   l a   p a g e   d ' a c c u e i l 
         r e t u r n   n e w   C o n t r o l l e r R e s p o n s e ( 
                 r e d i r e c t i o n :   R o u t e N a m e : : H O M E 
         ) ; 
 } 
 ` ` ` 
 
 #   U t i l i s e r   l e s   [ r e p o s i t o r y ] ( s r c / M o d e l / R e p o s i t o r y ) 
 
 >   L e s   a t t r i b u t s   d e s   [ o b j e t s ] ( s r c / M o d e l / O b j e c t )   s o n t   f o r t e m e n t   r e l i � s   �   l a   b a s e   d e   d o n n � e s   _ ( i l s   d o i v e n t   e x a c t e m e n t   l e   m � m e   n o m   d ' a i l l e u r s ) _ . 
 T o u s   l e s   [ r e p o s i t o r y ] ( s r c / M o d e l / R e p o s i t o r y )   h � r i t e   d e   [ C o r e R e p o s i t o r y ] ( s r c / M o d e l / R e p o s i t o r y / C o r e R e p o s i t o r y . p h p ) ,   i l s   o n t   d o n c   a c c � s   a u x   f o n c t i o n s   s e l e c t ( ) ,   i n s e r t ( ) ,   u p d a t e ( )   e t   d e l e t e ( ) . 
 -   # # #   S e l e c t 
 
 L a   f o n c t i o n   s e l e c t ( )   p o u r   r � c u p � r e r   d e s   o b j e t s   d e p u i s   l a   b a s e   d e   d o n n � e s   d e m a n d e   u n e   i n s t a n c e   d e   [ Q u e r y C o n d i t i o n ] ( s r c / L i b / D a t a b a s e / Q u e r y C o n d i t i o n . p h p ) ,   c e t   o b j e t   r � a l i s e   l ' � q u i v a l e n t   d e   " * * W H E R E   $ c o l u m n   $ c o m p a r i s o n O p e r a t o r   $ v a l u e * * " . 
 
 ` ` ` p h p 
 / / r e t o u r n e   u n   t a b l e a u   d ' o b j e t   � t u d i a n t 
 ( n e w   E t u d i a n t R e p o s i t o r y ) - > s e l e c t ( 
         n e w   Q u e r y C o n d i t i o n ( 
                 c o l u m n :   " l o g i n " , 
                 c o m p a r i s o n O p e r a t o r :   C o m p a r i s o n O p e r a t o r : : E Q U A L , 
                 v a l u e :   $ l o g i n 
         ) 
 ) ; 
 ` ` ` 
 D e s   f o n c t i o n s   d a n s   l e s   [ r e p o s i t o r y ] ( s r c / M o d e l / R e p o s i t o r y )   p e u v e n t   � t r e   p r � f a i t e   p o u r   l e s   a t t r i b u t s   s o u v e n t   u t i l i s �   ( c e u x   e n   c l �   p r i m a i r e   o u   u n i q u e )   p o u r   r � c u p � r e r   l e s   o b j e t s   d e p u i s   l a   b a s e   d e   d o n n � e s   p e u v e n t   r e m p l a c e r   l e   c o d e   p r � c � d e n t   p a r   f a c i l i t � : 
 ` ` ` p h p 
 / / r e t o u r n e   l ' o b j e t   d e   l ' � t u d i a n t   a y a n t   $ l o g i n   c o m m e   l o g i n   
 ( n e w   E t u d i a n t R e p o s i t o r y ) - > g e t B y L o g i n ( $ l o g i n ) ; 
 ` ` ` 
 
 -   # # #   I n s e r t 
 
 V o u s   p o u v e z   i n s � r e r   d i r e c t e m e n t   l e s   i n s t a n c e s   d ' o b j e t   d a n s   l a   b a s e   d e   d o n n � e s   g r � c e   �   l a   f o n c t i o n   i n s e r t ( ) .   L a   g r a n d e   m a j o r i t �   d e s   a t t r i b u t s   p e u v e n t   � t r e   ` n u l l ` ,   c e s   a t t r i b u t s   s e r o n t   i g n o r �   l o r s   d e   l ' i n s e r t i o n   e t   p r e n d r o n t   l a   v a l e u r   p a r   d � f a u t   ( s o u v e n t   N U L L ) . 
 ` ` ` p h p 
 / / r e t o u r n e   l ' i d   d e   l ' o b j e t   v e n a n t   d ' � t r e   i n s � r � ,   o u   f a l s e   e n   c a s   d ' e r r e u r 
 ( n e w   E t u d i a n t R e p o s i t o r y ) - > i n s e r t ( 
         n e w   E t u d i a n t ( 
                 l o g i n :   $ l o g i n , 
                 h a s h e d _ p a s s w o r d :   P a s s w o r d : : h a s h ( $ p a s s w o r d ) 
         ) 
 ) ; 
 ` ` ` 
 T o u s   l e s   o b j e t s   h � r i t e n t   t o u s   d e   [ C o r e O b j e c t ] ( s r c / M o d e l / O b j e c t / C o r e O b j e c t . p h p ) ,   c ' e s t   g r � c e   �   c e t t e   c l a s s e   q u e   C o r e R e p o s i t o r y   p e u t   r � c u p � r e r   l e s   n o m s   d e s   a t t r i b u t s   d e s   o b j e t s . 
 
 -   # # #   U p d a t e 
 L a   f o n c t i o n   u p d a t e ( )   u t i l i s e   �   l a   f o i s   u n e   i n s t a n c e   d e   [ C o r e O b j e c t ] ( s r c / M o d e l / O b j e c t / C o r e O b j e c t . p h p )   e t   u n e   d e   [ Q u e r y C o n d i t i o n ] ( s r c / L i b / D a t a b a s e / Q u e r y C o n d i t i o n . p h p ) .   U t i l i s e r   u n e   i n s t a n c e   d e   [ N u l l D a t a T y p e ] ( s r c / L i b / D a t a b a s e / N u l l D a t a T y p e . p h p )   p o u r   m e t t r e   l a   v a l e u r   e n   b a s e   d e   d o n n � e s   �   N U L L .   C a r   l e s   a t t r i b u t s   a v e c   l a   v a l e u r   ` n u l l `   s o n t   t o u t   s i m p l e m e n t   i g n o r � s . 
 ` ` ` p h p 
 / / m e t   l e   p r � n o m   �   N U L L   e t   d o n n e   l a   c i v i l i t �   F 
 / / �   t o u s   l e s   � t u d i a n t s   a y a n t s   u n   t � l � p h o n e   c o m m e n � a n t   p a r   0 6 
 ( n e w   E t u d i a n t R e p o s i t o r y ) - > u p d a t e ( 
         o b j e c t :   n e w   E t u d i a n t ( 
                 p r e n o m :   n e w   N u l l D a t a T y p e ( ) , 
                 c i v i l i t e :   ' F ' 
         ) , 
         c o n d i t i o n :   n e w   Q u e r y C o n d i t i o n ( 
                 c o l u m n :   " t e l e p h o n e " , 
                 c o m p a r i s o n O p e r a t o r :   C o m p a r i s o n O p e r a t o r : : L I K E , 
                 v a l u e :   " 0 6 % " 
         ) 
 ) ; 
 / / r e t o u r n e   u n   b o o l   s e l o n   l a   r � u s s i t e   d e   l ' u p d a t e 
 ` ` ` 
 
 -   # # #   D e l e t e 
 L a   f o n c t i o n   d e l e t e ( )   u t i l i s e   t o u t   s i m p l e m e n t   u n e   i n s t a n c e   d e   [ Q u e r y C o n d i t i o n ] ( s r c / L i b / D a t a b a s e / Q u e r y C o n d i t i o n . p h p )   p o u r   s u p p r i m e r   d e s   d o n n � e s . 
 ` ` ` p h p 
 / / s u p p r i m e   t o u s   l e s   � t u d i a n t s   m � l e s   d e   l a   b a s e   d e   d o n n � e s   
 ( n e w   E t u d i a n t R e p o s i t o r y ) - > d e l e t e ( 
         Q u e r y C o n d i t i o n ( " c i v i l i t e " ,   C o m p a r i s o n O p e r a t o r : : E Q U A L ,   ' M ' ) ; 
 ) ; 
 / / r e t o u r n e   u n   b o o l   s e l o n   l a   r � u s s i t e   d e   l a   s u p p r e s s i o n 
 ` ` ` 