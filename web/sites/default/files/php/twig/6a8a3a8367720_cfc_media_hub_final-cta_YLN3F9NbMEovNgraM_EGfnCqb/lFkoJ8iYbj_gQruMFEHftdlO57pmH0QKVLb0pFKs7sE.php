<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Sandbox\SecurityNotAllowedTestError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* cfc_media_hub:final-cta */
class __TwigTemplate_c28a8262534b9bef985e9c83ca31fcba extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--final-cta"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:final-cta"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:final-cta"));
        yield "<section class=\"bg-[#0F6E56] text-white py-36 relative overflow-hidden\">
  <div class=\"absolute inset-0 opacity-[0.08] pointer-events-none\" style=\"background-image: radial-gradient(circle at 1px 1px, white 1px, transparent 0); background-size: 32px 32px;\"></div>
  <div class=\"absolute -top-32 -right-20 w-[500px] h-[500px] rounded-full bg-[#085041] blur-3xl opacity-60\"></div>
  <div class=\"absolute -bottom-40 -left-20 w-[400px] h-[400px] rounded-full bg-[#CDEDE3]/10 blur-3xl\"></div>

  <div class=\"relative max-w-[1440px] mx-auto px-12 grid grid-cols-12 gap-12 items-center\">
    <div class=\"col-span-7\">
      <div class=\"flex items-center gap-3 mb-5\">
        <div class=\"w-6 h-[2px] bg-[#9F5434]\"></div>
        <div class=\"text-[12px] uppercase tracking-[0.18em] text-[#CDEDE3] font-semibold\">Start creating</div>
      </div>
      <h2 class=\"tracking-tight\" style=\"font-size: 76px; font-weight: 600; line-height: 1.02; letter-spacing: -0.03em;\">
        Ready to access<br />
        <span class=\"text-[#CDEDE3]\">the hub?</span>
      </h2>
      <p class=\"mt-7 text-white/80 leading-relaxed max-w-[480px] text-[18px]\">
        Book your space in seconds and start creating from Casablanca.
      </p>

      <div class=\"mt-10 flex items-center gap-4\">
        ";
        // line 21
        yield from $this->load("cfc_media_hub:final-cta", 21, 1)->unwrap()->yield(CoreExtension::merge($context, ["variant" => "white", "size" => "md", "href" => ($context["booking_base_url"] ?? null)]));
        // line 25
        yield "        <a href=\"mailto:mediahub@casablancafinancecity.com\" class=\"border border-white/25 hover:bg-white/10 text-white px-8 py-4 rounded-full text-[14px] font-medium backdrop-blur-sm inline-flex items-center\">
          Contact us
        </a>
      </div>
    </div>

    <div class=\"col-span-5\">
      <div class=\"bg-white/[0.07] border border-white/15 backdrop-blur-sm rounded-2xl p-8\">
        <div class=\"text-[12px] uppercase tracking-wide text-[#CDEDE3] font-semibold mb-5\">Next available slots</div>
        <div class=\"space-y-3\">
          ";
        // line 35
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["slots"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["s"]) {
            // line 36
            yield "            <div class=\"flex items-center justify-between py-3 border-b border-white/10 last:border-0\">
              <div>
                <div class=\"text-[14px] font-semibold\">";
            // line 38
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "title", [], "any", false, false, true, 38), "html", null, true);
            yield "</div>
                <div class=\"text-[12px] text-white/60 mt-0.5\">";
            // line 39
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "day_label", [], "any", false, false, true, 39), "html", null, true);
            yield " &middot; ";
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "time_range", [], "any", false, false, true, 39), "html", null, true);
            yield "</div>
              </div>
              <a href=\"";
            // line 41
            yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["s"], "book_url", [], "any", false, false, true, 41), "html", null, true);
            yield "\" class=\"text-[12px] bg-white text-[#9F5434] px-3.5 py-1.5 rounded-md hover:bg-[#9F5434] hover:text-white transition-colors font-semibold\">
                Book
              </a>
            </div>
          ";
            $context['_iterated'] = true;
        }
        // line 45
        if (!$context['_iterated']) {
            // line 46
            yield "            <p class=\"text-[13px] text-white/60\">No slots available right now — check the full calendar.</p>
          ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['s'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent);
        $context += $_parent;
        // line 48
        yield "        </div>
      </div>
    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["booking_base_url", "slots"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:final-cta";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  122 => 48,  114 => 46,  112 => 45,  103 => 41,  96 => 39,  92 => 38,  88 => 36,  83 => 35,  71 => 25,  69 => 21,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:final-cta", "themes/custom/cfc_media_hub/components/final-cta/final-cta.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["embed" => 21, "for" => 35];
        static $filters = ["escape" => 38];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "embed", 1 => "for"],
                [0 => "escape"],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}


/* cfc_media_hub:final-cta */
class __TwigTemplate_c28a8262534b9bef985e9c83ca31fcba___1 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->blocks = [
            'icon' => [$this, 'block_icon'],
            'label' => [$this, 'block_label'],
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
    }

    protected function doGetParent(array $context): bool|string|Template|TemplateWrapper
    {
        // line 21
        return "cfc_media_hub:button";
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->attachLibrary("core/components.cfc_media_hub--final-cta"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->addAdditionalContext($context, "cfc_media_hub:final-cta"));
        yield (string) $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\ComponentsTwigExtension']->validateProps($context, "cfc_media_hub:final-cta"));
        // line 21
        $this->parent = $this->load("cfc_media_hub:button", 21);
        yield from $this->parent->unwrap()->yield($context, array_merge($this->blocks, $blocks));
    }

    // line 22
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_icon(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield from $this->load("cfc_media_hub:icon", 22)->unwrap()->yield(CoreExtension::toArray(["name" => "calendar", "size" => "w-4 h-4"]));
        yield from [];
    }

    // line 23
    /**
     * @return iterable<null|scalar|\Stringable>
     */
    public function block_label(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        yield "Check availability";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "cfc_media_hub:final-cta";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  255 => 23,  244 => 22,  239 => 21,  235 => 1,  228 => 21,  122 => 48,  114 => 46,  112 => 45,  103 => 41,  96 => 39,  92 => 38,  88 => 36,  83 => 35,  71 => 25,  69 => 21,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "cfc_media_hub:final-cta", "themes/custom/cfc_media_hub/components/final-cta/final-cta.twig");
    }
    
    public function ensureSecurityChecked(): void
    {
        if ($this->sandbox->isSandboxed($this->source)) {
            $this->checkSecurity();
        }
    }
    
    public function checkSecurity()
    {
        static $tags = ["extends" => 21, "include" => 22];
        static $filters = [];
        static $functions = [];
        static $tests = [];

        try {
            $this->sandbox->checkSecurity(
                [0 => "extends", 1 => "include"],
                [],
                [],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            } elseif ($e instanceof SecurityNotAllowedTestError && isset($tests[$e->getTestName()])) {
                $e->setTemplateLine($tests[$e->getTestName()]);
            }

            throw $e;
        }

    }
}
